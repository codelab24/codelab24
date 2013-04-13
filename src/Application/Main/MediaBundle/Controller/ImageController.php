<?php

namespace Application\Main\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Main\MediaBundle\Entity\Image;
use Application\Main\MediaBundle\Form\ImageType;

/**
 * Image controller.
 *
 * @Route("/image")
 */
class ImageController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/", name="image")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationMainMediaBundle:Image')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/", name="image_create")
     * @Method("POST")
     * @Template("ApplicationMainMediaBundle:Image:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Image();
        $form = $this->createForm(new ImageType(), $entity);
        $form->bind($request);
        $session = $this->getRequest()->getSession();
        $image = $session->get('image');

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            //var_dump($image); exit;
            if($image['type'] == 'artist'){

                //this is artist
                $artist = $em->getRepository('ApplicationMainContributorBundle:Artist')->find($image['id']);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Image entity.');
                }

                $artist->addImage($entity);
                $em->persist($artist);
            }elseif($image['type'] == 'album'){
                //this is album
                $album = $em->getRepository('ApplicationMainMediaBundle:Album')->find($image['id']);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Album entity.');
                }

                $album->addImage($entity);
                $em->persist($album);

            }


            $em->flush();

            if($image['type'] == 'artist'){
                //clear session
                return $this->redirect($this->generateUrl('artist_show', array('id' => $artist->getId())));

            }elseif($image['type'] == 'album'){
                return $this->redirect($this->generateUrl('album_show', array('id' => $album->getId())));
            }

            //default
            return $this->redirect($this->generateUrl('image_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="image_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Image();
        $form   = $this->createForm(new ImageType(), $entity);


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/{id}", name="image_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/{id}/edit", name="image_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $editForm = $this->createForm(new ImageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Image entity.
     *
     * @Route("/{id}", name="image_update")
     * @Method("PUT")
     * @Template("ApplicationMainMediaBundle:Image:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ImageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            //trigger pre update & persist
            if ($editForm->get('file')->getData() != NULL) {//user have uploaded a new file
                $file = $editForm->get('file')->getData();//get 'UploadedFile' object
                $entity->setPath($file->getClientOriginalName());//change field that holds file's path in db to a temporary value,i.e original file name uploaded by user
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('image_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}", name="image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationMainMediaBundle:Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('image'));
    }

    /**
     * Creates a form to delete a Image entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

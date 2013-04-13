<?php

namespace Application\Main\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Main\MediaBundle\Entity\Album;
use Application\Main\MediaBundle\Form\AlbumType;

/**
 * Album controller.
 *
 * @Route("/album")
 */
class AlbumController extends Controller
{
    /**
     * Lists all Album entities.
     *
     * @Route("/", name="album")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationMainMediaBundle:Album')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Album entities.
     *
     * @Route("/artist/{id}", name="album_artist")
     * @Method("GET")
     * @Template("ApplicationMainMediaBundle:Album:index.html.twig")
     */
    public function artistAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationMainMediaBundle:Album')->getAlbumsByArtist($id);
        //var_dump($entities); exit;

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Album entity.
     *
     * @Route("/", name="album_create")
     * @Method("POST")
     * @Template("ApplicationMainMediaBundle:Album:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Album();
        $form = $this->createForm(new AlbumType(), $entity);
        $form->bind($request);
        $session = $this->getRequest()->getSession();
        $album_artist = $session->get('album_artist');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            if($album_artist >= 1){
                //this is artist
                $artist = $em->getRepository('ApplicationMainContributorBundle:Artist')->find($album_artist);
                //exit if not found
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Artist entity.');
                }

                $artist->addAlbum($entity);
                $em->persist($artist);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('album_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Album entity.
     *
     * @Route("/new", name="album_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->createForm(new AlbumType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/{id}", name="album_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $session = $this->getRequest()->getSession();
        $image = $session->set('image', array('type' => 'album', 'id' => $id));
        $album = $session->set('album_song', $id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     * @Route("/{id}/edit", name="album_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm = $this->createForm(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Album entity.
     *
     * @Route("/{id}", name="album_update")
     * @Method("PUT")
     * @Template("ApplicationMainMediaBundle:Album:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainMediaBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AlbumType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('album_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Album entity.
     *
     * @Route("/{id}", name="album_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationMainMediaBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('album'));
    }

    /**
     * Creates a form to delete a Album entity by id.
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

<?php

namespace Application\Main\CartBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\Main\CartBundle\Entity\Cart;
use Application\Main\CartBundle\Form\CartType;

/**
 * Cart controller.
 *
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * Lists all Cart entities.
     *
     * @Route("/index", name="cart_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ApplicationMainCartBundle:Cart')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    ///
    /**
     * Lists all Cart entities.
     *
     * @Route("/add/{item}/{code}/{id}", name="cart_add")
     * @Method("GET")
     * @Template("ApplicationMainCartBundle:Cart:cart.html.twig")
     */
    public function addAction($item, $code, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('ApplicationMainCartBundle:Product')->getProductByCode($code);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
        //a song is selected
        if($item == 'song'){
          $product_info =  $em->getRepository('ApplicationMainMediaBundle:Song')->find($id);
          if (!$product_info) {
                throw $this->createNotFoundException('Unable to find Song entity.');
          }

            //add image artists etc
        }

        $product_id = $product->getId();
        $price = $product->getPrice();
        $title = $product_info->getTitle();
        $i = 0;
        $isFound = false;
        $session = $this->getRequest()->getSession();
        if(count($session->get('cart_array')) < 1){
            //empty cart - add item
            $session->set('cart_array', array(0 => array('item_id' => $id,  'quantity' => 1, 'price' => $price, 'title' => $title, 'subtotal' => 1)));

        }else{
            //cart has atleast 1
            $cart_session = $session->get('cart_array');

            foreach($cart_session as $each_item){
                $i++;
                while(list($key, $value)=each($each_item)){
                    if($key == 'item_id' && $value == $id){
                        $qty = $each_item['quantity']+1;
                        $priceTotal = $price * $qty;
                        array_splice($cart_session,
                                     $i-1, 1, array(array('item_id' => $id,
                                                          'quantity' => $qty,
                                                          'price' => $price, 'title' => $title,'subtotal' => $priceTotal )));
                        $session->set('cart_array', $cart_session);
                        $isFound = true;
                    }
                }
                if($isFound == false){
                    //cart has atleast 1 item but not this
                    $cart_session = $session->get('cart_array');
                    array_push($cart_session, array('item_id' => $id, 'quantity' => 1, 'price' => $price, 'title' => $title, 'subtotal' => 1));
                    $session->set('cart_array', $cart_session);
                }
            }

        }
        //var_dump($session->get('cart_array')); exit;
        //all good
        return $this->redirect($this->generateUrl('cart'));
    }
    /**
     * Lists all Cart entities.
     *
     * @Route("/empty", name="cart_empty")
     * @Method("GET")
     * @Template()
     */
    public function emptyAction()
    {
        $session = $this->getRequest()->getSession();
        $session->clear('cart_array');



        //all good
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * Lists all Cart entities.
     *
     * @Route("/remove/{id}", name="cart_remove")
     * @Method("GET")
     * @Template()
     */
    public function removeAction($id)
    {
        $session = $this->getRequest()->getSession();

        if(count($session->get('cart_array')) <= 1){
            $session->clear('cart_array');
        }else {
            $cart = $session->get('cart_array');
            //var_dump($cart[$id]); exit;
            unset($cart[$id]);
            sort($cart);
            $session->set('cart_array', $cart);
        }
        //all good
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * Lists all Cart entities.
     *
     * @Route("/", name="cart")
     * @Method("GET")
     * @Template()
     */
    public function cartAction()
    {
        $session = $this->getRequest()->getSession();
        $cart = $session->get('cart_array') ;
        $i = 0;
        $total = 0;
        if(count($cart) < 1){
            $cart = null;
        }else{

            foreach($cart as $each_item){
                $total = $each_item['subtotal'] + $total;
                $i++;
            }
        }

        return array(
            'cart' => $cart,
            'total' => $total
        );
    }
    ///

    /**
     * Creates a new Cart entity.
     *
     * @Route("/", name="cart_create")
     * @Method("POST")
     * @Template("ApplicationMainCartBundle:Cart:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Cart();
        $form = $this->createForm(new CartType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cart_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Cart entity.
     *
     * @Route("/new", name="cart_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cart();
        $form   = $this->createForm(new CartType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cart entity.
     *
     * @Route("/{id}", name="cart_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainCartBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cart entity.
     *
     * @Route("/{id}/edit", name="cart_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainCartBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        $editForm = $this->createForm(new CartType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Cart entity.
     *
     * @Route("/{id}", name="cart_update")
     * @Method("PUT")
     * @Template("ApplicationMainCartBundle:Cart:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ApplicationMainCartBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CartType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cart_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Cart entity.
     *
     * @Route("/{id}", name="cart_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ApplicationMainCartBundle:Cart')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cart entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * Creates a form to delete a Cart entity by id.
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

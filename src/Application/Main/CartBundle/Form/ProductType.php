<?php

namespace Application\Main\CartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
//            ->add('code')
            ->add('price')
            ->add('isActive')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('categories', null, array('required' => false))
            ->add('carts', null, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\CartBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'application_main_cartbundle_producttype';
    }
}

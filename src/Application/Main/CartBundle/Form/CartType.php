<?php

namespace Application\Main\CartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('code')
            ->add('amount')
            ->add('status')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('products', null, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\CartBundle\Entity\Cart'
        ));
    }

    public function getName()
    {
        return 'application_main_cartbundle_carttype';
    }
}

<?php

namespace Application\Main\CartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('isActive')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('products', null, array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\CartBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'application_main_cartbundle_categorytype';
    }
}

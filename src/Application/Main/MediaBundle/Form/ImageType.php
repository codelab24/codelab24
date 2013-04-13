<?php

namespace Application\Main\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('title')
//            ->add('approved')
            ->add('file', null, array('label' => 'Select a file'))
//            ->add('created')
//            ->add('updated')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\MediaBundle\Entity\Image'
        ));
    }

    public function getName()
    {
        return 'application_main_mediabundle_imagetype';
    }
}

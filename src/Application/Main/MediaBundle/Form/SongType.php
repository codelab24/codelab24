<?php

namespace Application\Main\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('isActive')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('product')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\MediaBundle\Entity\Song'
        ));
    }

    public function getName()
    {
        return 'application_main_mediabundle_songtype';
    }
}

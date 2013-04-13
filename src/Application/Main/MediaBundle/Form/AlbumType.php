<?php

namespace Application\Main\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('code')
            ->add('title')
//            ->add('slug')
            ->add('description')
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('artists')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\MediaBundle\Entity\Album'
        ));
    }

    public function getName()
    {
        return 'application_main_mediabundle_albumtype';
    }
}

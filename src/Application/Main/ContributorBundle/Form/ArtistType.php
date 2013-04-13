<?php

namespace Application\Main\ContributorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('code')
            ->add('title')
//            ->add('slug')
            ->add('description')
//            ->add('isActive')
//            ->add('createdAt')
//            ->add('updatedAt')
//            ->add('albums')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Main\ContributorBundle\Entity\Artist'
        ));
    }

    public function getName()
    {
        return 'application_main_contributorbundle_artisttype';
    }
}

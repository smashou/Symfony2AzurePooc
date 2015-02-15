<?php

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', null, ["label" => "Title"] )
        ->add('content', "textarea", ["label" => "Content"] )
        ->add('notebook', 'entity', [
            'class' => "AppBundle\Entity\Notebook"
        ]);
    }

    public function getName()
    {
        return 'note';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Note',
        ));
    }
}

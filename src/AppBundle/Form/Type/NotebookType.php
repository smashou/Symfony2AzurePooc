<?php

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class NotebookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', null, [ "label" => "Name" ] )
        ->add('description', "textarea", [ "label" => "Description" ] )
        ->add('file', 'file', [ "label" => "Picture", "required" => false ]);
    }

    public function getName()
    {
        return 'notebook';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Notebook',
        ));
    }
}

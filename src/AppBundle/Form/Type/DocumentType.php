<?php

namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', 'file', [
                'label' => "Attachment",
                'required'     => false,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
    }

    public function getName()
    {
        return 'document';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document',
        ));
    }
}

<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\GlobalValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProveedorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('razonsocial')
        ->add('domicilio')
        ->add('condicioniva', ChoiceType::class, array(
                        'choices' => GlobalValue::CONDICION_IVA_SELECT,
                        'label'=>'Condicion Iva',
                        'required'=>false
                        )
                    )
        ->add('email')->add('percepcion')->add('cuit')->add('ingbrutos')->add('codpostal')->add('cbu');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Proveedor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_proveedor';
    }


}

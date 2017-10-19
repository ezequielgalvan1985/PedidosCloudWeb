<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EmpleadoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')->add('apellido')
                ->add('email', EmailType::class )
                ->add('ndoc')->add('direccion')
                ->add('telefono')
                ->add('tipo',ChoiceType::class, array(
                        'choices' => array(
                            GlobalValue::ROLE_VENDEDOR_DISPLAY=> GlobalValue::ROLE_VENDEDOR,
                            GlobalValue::ROLE_CARGADATOS_DISPLAY => GlobalValue::ROLE_CARGADATOS,
                            GlobalValue::ROLE_DEPOSITO_DISPLAY=> GlobalValue::ROLE_DEPOSITO
                            )
                        )
                    );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Empleado'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_empleado';
    }


}

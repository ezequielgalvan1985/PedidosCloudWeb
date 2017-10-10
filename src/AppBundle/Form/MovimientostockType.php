<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MovimientostockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fecha', DateType::class, [   'widget' => 'single_text', 'required'  => true])
                ->add('cantidad' )
                ->add('nrocomprobante')
                ->add('tipomovimiento', ChoiceType::class, array(
                        'choices'   => array('Ingreso' => '1', 'Egreso' => '2'),
                        'required'  => true))
                ->add('proveedor', EntityType::class, array(
                        'class' => 'AppBundle:Proveedor',
                        'choice_label' => 'razonsocial',
                    ))
                ->add('producto', EntityType::class, array(
                        'class' => 'AppBundle:Producto',
                        'choice_label' => 'nombre',
                    ))
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Movimientostock'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_movimientostock';
    }


}

<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PedidoHoyFilterType extends AbstractType
{
    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('estadoid', ChoiceType::class, array(
                        'choices'   => array('Pendiente' => '1', 'Enviado' => '2', 'Entregado' => '3', 'Rechazado' => '4'),
                        'required'  => false))
                ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedido'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_Pedido';
    }


}

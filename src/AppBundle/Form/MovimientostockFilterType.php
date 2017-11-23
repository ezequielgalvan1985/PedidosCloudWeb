<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\GlobalValue;


class MovimientostockFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechadesde',  DateType::class, [ 'widget' => 'single_text', 'label'=>'Fecha Desde', 'required'=>false]  )
                ->add('fechahasta',  DateType::class, [ 'widget' => 'single_text', 'label'=>'Fecha Hasta', 'required'=>false]  )
                ->add('tipomovimiento', ChoiceType::class, array(
                        'choices'   => GlobalValue::TIPOMOVIMIENTOS_SELECT,
                        'required'  => false))
                ->add('producto', EntityType::class, array(
                        'class' => 'AppBundle:Producto',
                        'choice_label' => 'nombre',
                        'required'=>false
                    ))
                //->add('codigoexterno')
                ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
                
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
        return 'appbundle_Movimientostock';
    }


}

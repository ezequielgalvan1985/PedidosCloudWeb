<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class HojarutaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('diaId',ChoiceType::class, array(
                        'choices' => array(
                            GlobalValue::LUNES_DISPLAY=> GlobalValue::LUNES_ID,
                            GlobalValue::MARTES_DISPLAY => GlobalValue::MARTES_ID,
                            GlobalValue::MIERCOLES_DISPLAY=> GlobalValue::MIERCOLES_ID,
                            GlobalValue::JUEVES_DISPLAY=> GlobalValue::JUEVES_ID,
                            GlobalValue::VIERNES_DISPLAY=> GlobalValue::VIERNES_ID,
                            GlobalValue::SABADOS_DISPLAY=> GlobalValue::SABADOS_ID,
                            )
                        )
                    )
                
                ->add('titulo')
                ->add('notas', TextareaType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Hojaruta'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_hojaruta';
    }


}

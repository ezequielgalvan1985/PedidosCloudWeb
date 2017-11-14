<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\GlobalValue;


class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('razonsocial', null, array('label'=>'Razon Social','required'  => true))
                ->add('contacto', null, array('label'=>'Contacto', 'required'  => true))
                ->add('condicioniva', ChoiceType::class, array(
                        'choices' => GlobalValue::CONDICION_IVA_SELECT,
                        'label'=>'Condicion Iva',
                        'required'=>false
                        )
                    )
                ->add('tipodocumento', ChoiceType::class, array(
                        'choices' => GlobalValue::TIPODOC_SELECT,
                        'label'=> 'Tipo Documento',
                        'required'=>false
                    ))
                ->add('ndoc', null, array('label'=>'Numero Doc.','required'  => true))
                ->add('telefono')
                ->add('direccion')
                ->add('email', EmailType::class, array('required'  => false))
                ->add('web')
                ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cliente';
    }


}

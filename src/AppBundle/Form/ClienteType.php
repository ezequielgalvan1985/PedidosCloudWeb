<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('razonsocial', null, array('label'=>'Razon Social'))
                ->add('contacto', null, array('label'=>'Contacto'))
                ->add('condicioniva', EntityType::class, array(
                        'class' => 'AppBundle:Condicioniva',
                        'choice_label' => 'nombre',
                        'label'=> 'Condicion Iva'
                    ))
                ->add('tipodocumento', EntityType::class, array(
                        'class' => 'AppBundle:Tipodocumento',
                        'choice_label' => 'nombre',
                        'label'=> 'Tipo Documento'
                    ))
                
                ->add('ndoc', null, array('label'=>'Numero Doc.'))
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

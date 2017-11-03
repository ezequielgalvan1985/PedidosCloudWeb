<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Entity\GlobalValue;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArchivoFilterType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('nombre')
                ->add('descripcion')
                ->add('tipo',ChoiceType::class, array(
                        'choices' => GlobalValue::ARCHIVO_TIPO_SELECT,
                        'label'=>'Contenido',
                        'required'=>true
                        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Archivo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_archivo';
    }


}

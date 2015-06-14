<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegleType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
        ->add('intitule', 'text',array(
            'label' => 'Intitulé de la regle:'
        ))
        ->add('message', 'textarea',array(
            'label' => 'regle:',
            'max_length' => 5000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer',
            'attr'=>array('class' => 'droite')
        ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zrtcommunity\Domain\Regle',
        ));
    }

    public function getName()
    {
        return 'regle';
    }
}

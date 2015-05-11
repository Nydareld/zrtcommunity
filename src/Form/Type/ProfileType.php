<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('avatar','file',array(
            'required'=>false
        ))
        ->add('sign', 'textarea',array(
            'required'=>false,
            'label' => 'Signature(1000 caracteres):',
            'max_length' => 1000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer',
            'attr'=>array('class' => 'droite')
        ));
    }

    public function getName()
    {
        return 'userprofil';
    }
}

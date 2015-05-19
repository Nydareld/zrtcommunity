<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;

class ProfileType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('avatar','file',array(
            'required'=>false,
            'constraints'=> array('image'=>new Image(array(
                'maxSize'=>"50k",
                'maxWidth'=>200,
                'maxHeight'=>200
            )))
        ))
        ->add('sign', 'textarea',array(
            'required'=>false,
            'label' => 'Signature(1000 caracteres):',
            'max_length' => 1000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('biographie', 'textarea',array(
            'required'=>false,
            'label' => 'Signature(10000 caracteres):',
            'max_length' => 10000,
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

<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('avatar','file',array(
            'required'=>'false',
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

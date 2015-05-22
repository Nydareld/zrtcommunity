<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ModRoleType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $roles = array(
            'ROLE_ADMIN'=>'Administrateur',
            'ROLE_MODO'=>'Modérateur',
            'ROLE_TARD'=>'Tard',
            'ROLE_USER'=>'Péon');

        $builder

        ->add('role','choice',array(
            'choices'=>$roles
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer',
            'attr'=>array('class' => 'droite')
        ));
    }

    public function getName()
    {
        return 'role';
    }
}

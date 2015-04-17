<?php

namespace Pecheocoup\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('username', 'text')
        ->add('password', 'repeated', array(
            'type'            => 'password',
            'invalid_message' => 'Les mots de passes doivent etre identitques',
            'options'         => array('required' => true),
            'first_options'   => array('label' => 'Mot de passe'),
            'second_options'  => array('label' => 'repetez votre mot de passe'),
        ))
        ->add('email', 'repeated', array(
            'type'            => 'email',
            'invalid_message' => 'Les emails doivent etre identitques',
            'options'         => array('required' => true),
            'first_options'   => array('label' => 'email'),
            'second_options'  => array('label' => 'repetez votre email'),
        ))
        ->add('role', 'hidden', array(
            'data' => 'ROLE_USER',
        ));
    }

    public function getName()
    {
        return 'user';
    }
}

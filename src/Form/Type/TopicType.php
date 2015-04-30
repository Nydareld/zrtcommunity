<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TopicType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('name', 'text',array(
            'label' => 'Nom du sujet:'
        ))
        ->add('description', 'text',array(
            'label' => 'Déscription:'
        ))
        ->add('contenu', 'textarea',array(
            'mapped' => false,
            'label' => 'Votre message:',
            'max_length' => 5000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer',
            'attr'=>array('class' => 'droite')
        ));
    }

    public function getName()
    {
        return 'topic';
    }
}

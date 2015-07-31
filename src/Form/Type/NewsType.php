<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('name', 'text',array(
            'label' => 'Nom de la news:'
        ))
        ->add('contenu', 'textarea',array(
            'label' => 'Votre message:',
            'max_length' => 10000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('hidden','choice', array(
            'label'=>'cacher le news aux non-modos ?',
            'choices'=>array(1=>"oui",0=>"non")
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

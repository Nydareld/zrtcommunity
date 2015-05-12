<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MPType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $builder
        ->add('titre', 'text',array(
            'label' => 'Titre du message:'
        ))
        ->add('contenu', 'textarea',array(
            'label' => 'Contenu:',
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
        return 'projet';
    }
}

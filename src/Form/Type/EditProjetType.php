<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EditProjetType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $builder
        ->add('description', 'textarea',array(
            'label' => 'Description:',
            'max_length' => 10000,
            'attr'=>array('class'=>'ckeditor')
        ))
        ->add('recrute','choice', array(
            'label'=>'le projet recrute ?',
            'choices'=>array(1=>"oui",0=>"non")
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

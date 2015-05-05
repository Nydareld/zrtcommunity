<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegionType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
        ->add('name', 'text',array(
            'label' => 'Nom de la région:'
        ))
        ->add('description', 'textarea',array(
            'label' => 'Description:',
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

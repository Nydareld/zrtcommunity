<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorieType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $builder
        ->add('name', 'text',array(
            'label' => 'Nom nouvelle catégorie:'
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer'
        ));
    }

    public function getName()
    {
        return 'categorie';
    }
}

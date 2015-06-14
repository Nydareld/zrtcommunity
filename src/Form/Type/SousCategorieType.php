<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SousCategorieType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $scat=$app['dao.scat']->findAllNamesAsArrayBySection($options['attr']['section']);

        $builder
        ->add('name', 'text',array(
            'label' => 'Nom nouvelle sous-catégorie:'
        ))
        ->add('description', 'text',array(
            'label' => 'Déscription de la sous-catégorie:'
        ))
        ->add('parent','choice',array(
            'mapped' => false,
            'label' => 'Sous-catégorie mere:',
            'choices'=>$scat
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer'
        ));
    }

    public function getName()
    {
        return 'SousCatDeSousCat';
    }
}

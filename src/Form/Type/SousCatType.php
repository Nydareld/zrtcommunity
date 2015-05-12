<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SousCatType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $cat=$app['dao.categorie']->findAllNamesAsArray();

        $builder
        ->add('name', 'text',array(
            'label' => 'Nom nouvelle sous-catégorie:'
        ))
        ->add('description', 'text',array(
            'label' => 'Déscription de la sous-catégorie:'
        ))
        ->add('parent','choice',array(
            'mapped' => false,
            'label' => 'Catégorie mere:',
            'choices'=>$cat
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer'
        ));
    }

    public function getName()
    {
        return 'sousCatDeCat';
    }
}

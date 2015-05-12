<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SousCategorieType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $scat=$app['dao.scat']->findAllNamesAsArray();

        $builder
        ->add('name', 'text',array(
            'label' => 'Nom nouvelle sous-catégorie:'
        ))
        ->add('description', 'text',array(
            'label' => 'Déscription de la sous-catégorie:'
        ))
        ->add('parent','choice',array(
            'mapped' => false,
            'choices'=>$scat
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

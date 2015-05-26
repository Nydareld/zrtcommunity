<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MoveTopicType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        global $app;

        $scat=$app['dao.scat']->findAllNamesAsArray();

        $builder
        ->add('scat','choice',array(
            'mapped' => false,
            'label' => 'Nouvelle sous-catégorie:',
            'choices'=>$scat
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer'
        ));
    }

    public function getName()
    {
        return 'MoveTopicType';
    }
}

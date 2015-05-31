<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ModRoleType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        global $app;

        $sections = $app['dao.section']->findAllNamesAsArray();

        $roleSection = array('aucun role','admin de section','modo de section');

        $roles = array(
            'ROLE_ADMIN'=>'Administrateur',
            'ROLE_MODO'=>'Modérateur',
            'ROLE_TARD'=>'Tard',
            'ROLE_USER'=>'Péon');

        $builder

        ->add('role','choice',array(
            'label' => 'role global',
            'choices'=>$roles
        ))
        ->add('RolesectionSite','choice',array(
            'mapped' => false,
            'label' => 'role de section:',
            'choices'=>$roleSection
        ))
        ->add('sectionSite','choice',array(
            'mapped' => false,
            'label' => 'Section du site:',
            'choices'=>$sections
        ))
        ->add('save', 'submit', array(
            'label' => 'Envoyer',
            'attr'=>array('class' => 'droite')
        ));
    }

    public function getName()
    {
        return 'role';
    }
}

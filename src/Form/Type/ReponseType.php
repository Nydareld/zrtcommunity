<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReponseType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        //recuprer la question
        $builder
        ->add('reponse', 'text',array(
            'label' => ' '
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zrtcommunity\Domain\Reponse',
        ));
    }

    public function getName()
    {
        return 'reponse';
    }
}

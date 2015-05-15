<?php

namespace Zrtcommunity\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModelQuestionaireType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
        ->add('questions', 'collection',array(
            'type' => new QuestionType(),
            'allow_add' => true,
            'by_reference' => false,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zrtcommunity\Domain\ModelQuestionaire',
        ));
    }

    public function getName()
    {
        return 'modelQuestionaire';
    }
}

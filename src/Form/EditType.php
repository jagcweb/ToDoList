<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->setMethod('POST')
        ->add('title', TextType::class, [
            'label' => "Title"
        ])
        ->add('content', TextareaType::class, [
            'label' => "Content"
        ])
        ->add('priority', ChoiceType::class, [
            'label' => "Priority",
            'choices' => array(
                'high' => 'high',
                'medium' => 'medium',
                'low' => 'low'
            )
        ])
        ->add('hours', TextType::class, [
            'label' => "Hours"
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Edit Task',
            'attr' => [ 'class' => 'btn' ],
        ]); //Sin el get form

    }

}
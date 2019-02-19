<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\{Advert, Skill, AdvertSkill, Category};
use App\Form\{ImageType, SkillType, AdvertSkillType, CategoryType};

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',  DateTimeType::class)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('image', ImageType::class)
            ->add('published', CheckboxType::class, ['required' => false])
            ->add('advertSkills', CollectionType::class, [
                'entry_type' => AdvertSkillType::class,
                'label'        => 'List skills',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
            ])
            /*->add('Categories', CollectionType::class, [
                'entry_type' => CategoryType::class,
                'label'        => 'List Categories',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
            ])*/

            ->add('Categories', EntityType::class, [
                'class' => Category::class,
                'label' =>'Categories', 
                'choice_label' => 'name',
                'expanded' => false,
                'multiple'      => true, 
            ])

            /*->add('categories', EntityType::class, [
                'label' =>'Categories', 
                'placeholder' => 'Choose an option',
                'class' => Category::class,
                'choice_label'  => function( $categories){
                    return $categories->getName();
                }
            ])*/
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}

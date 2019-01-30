<?php

namespace App\Form;

use App\Entity\{AdvertSkill, Skill};
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\SkillType;

class AdvertSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skill', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'label' => 'Skills',
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])

            ->add('level', ChoiceType::class, [
                'choices'  => [
                    'Expert' => 'Expert',
                    'Avisé' => 'Avisé',
                    'Débutant' => 'Débutant',
                ],
            ])

            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSkill::class,
        ]);
    }
}

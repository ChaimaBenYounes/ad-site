<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('name', EntityType::class, [
                'label' =>'Categories', 
                'placeholder' => 'Choose an option',
                'class' => Category::class,
                'choice_label'  => function( $name){
                    return $name->getName();
                }
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
  
}

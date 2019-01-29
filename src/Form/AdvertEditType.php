<?php

namespace App\Form;

use App\Entity\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\ImageType;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->remove('date'); 
    }

    public function getParent()
    {
      return AdvertType::class;
    }

    
}

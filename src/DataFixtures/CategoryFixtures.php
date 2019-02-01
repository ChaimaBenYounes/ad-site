<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture 
{
    public function load(ObjectManager $manager) 
    {
        $categoriesName = [
            'Développement Web',
            'Développement Mobile',
            'Graphisme', 
            'Integration', 
            'Réseau'
            ];
        foreach($categoriesName as $name){

           $category = new Category();
           $category->setName($name);
           $manager->persist($category);
        }
        $manager->flush();
    }

   
}

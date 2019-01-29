<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\{Skill, Advert, AdvertSkill};
use App\Repository\{AdvertRepository,SkillRepository};

class AdvertSkillFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adverts = $advertsRepository = $manager->getRepository(Advert::class)->findAll();
        $skills = $advertsRepository = $manager->getRepository(Skill::class)->findAll();
        $level = ['Débutant', 'Avisé ', 'Expert'];

        //var_dump($adverts[array_rand($adverts)]); die();

        for ($i=1; $i < 30; $i++) {
            $advertSkill = new AdvertSkill();
            
                $advertSkill->setLevel($level[array_rand($level)]);
          
                $advertSkill->setAdvert($adverts[array_rand($adverts)]);

                $advertSkill->setSkill($skills[array_rand($skills)]);
           
            $manager->persist($advertSkill);
        }
       

        $manager->flush();
    }
}

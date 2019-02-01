<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\{Skill, Advert, AdvertSkill};
use App\Repository\{AdvertRepository,SkillRepository};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\{SkillFixture, AdvertFixtures};

class AdvertSkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adverts = $manager->getRepository(Advert::class)->findAll();
        $skills = $manager->getRepository(Skill::class)->findAll();
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

    public function getDependencies() {
        return [
            SkillFixture::class,
            AdvertFixtures::class,
        ];
    }
}

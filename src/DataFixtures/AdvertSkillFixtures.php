<?php

namespace App\DataFixtures;

use App\Entity\{Skill, Advert, AdvertSkill};
use App\Repository\{AdvertRepository,SkillRepository};
use App\DataFixtures\{SkillFixture, AdvertFixtures};
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdvertSkillFixtures extends Fixture implements DependentFixtureInterface
{

    private static $level = ['Débutant', 'Avisé ', 'Expert'];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'main_advertSkill', function($i) use ($manager) {

            $advertSkill = new AdvertSkill();
            $advertSkill->setLevel($this->faker->randomElement(self::$level));
            $advertSkill->setAdvert($this->getRandomReference('main_adverts'));
            $advertSkill->setSkill($this->getRandomReference('main_skill'));

            return $advertSkill;
        });

        $manager->flush();

    }

    public function getDependencies() {
        return [
            AdvertFixtures::class,
            SkillFixture::class,
        ];
    }
}

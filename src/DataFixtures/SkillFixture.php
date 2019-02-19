<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Common\Persistence\ObjectManager;

class SkillFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'main_skill', function($i) use ($manager) {
            $skill = new Skill();
            $skill->setName($this->faker->firstName);

            return $skill;
        });

        $manager->flush();
    }
}

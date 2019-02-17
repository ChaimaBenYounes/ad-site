<?php

namespace App\DataFixtures;

use App\Entity\{Advert,Image, User};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdvertFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(30, 'main_adverts', function($i) use ($manager) {

            $advert = new Advert();
            $advert->setDate($this->faker->dateTimeBetween('-1 years', 'now', null));
            $advert->setTitle($this->faker->sentence(2,true));
            $advert->setAuthor($this->getRandomReference('main_users_Entreprise'));
            $advert->setContent($this->faker->text(200));
            $advert->setPublished($this->faker->boolean);
            $image = new Image();
            $image->setUrl($this->faker->imageUrl(640,480));
            $image->setAlt($this->faker->sentence(20,true));

            $advert->setImage($image);

            return $advert;
        });

        $manager->flush();

    }
    public function getDependencies() {
        return [
            UserFixture::class,
        ];
    }
 
}

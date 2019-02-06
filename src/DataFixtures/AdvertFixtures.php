<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\{Advert,Image, User};
use App\DataFixtures\UserFixture;


class AdvertFixtures extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
       $this->faker = Factory::create();
       $this->addFaker($manager);
       $manager->flush();
    }

    private function addFaker(ObjectManager $em){

        $users = $em->getRepository(User::class)->findAll();
        //$users = $em->getRepository(User::class)->findOneBy(['email'=> $credentials['email']]);
        //$roles


        for ($i=1; $i < 30; $i++) {

            $advert = new Advert();
            $advert->setDate($this->faker->dateTime('now',null));
            $advert->setTitle($this->faker->sentence(2,true));
            //$advert->setAuthor($users[array_rand($users)]);
            $advert->setContent($this->faker->text(200));
            $advert->setPublished($this->faker->boolean); 

            $image = new Image();
            $image->setUrl($this->faker->imageUrl(640,480));
            $image->setAlt($this->faker->sentence(20,true));

            $advert->setImage($image);
            
            $em->persist($advert);
        }
        
    }
    public function getDependencies() {
        return [
            UserFixture::class,
        ];
    }
 
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
  
    public function load(ObjectManager $manager)
    {

        $listNames = array('Alexandre', 'Marine', 'Anna');
    
        foreach ($listNames as $name) {
          // On crée l'utilisateur
          $user = new User;
    
          // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
          $user->setFirstName($name);
          $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));
          $user->setEmail('user.'.$name.'@gmail.com');
        
          // On définit uniquement le role ROLE_USER qui est le role de base
          $user->setRoles(['ROLE_USER']);
    
          // On le persiste
          $manager->persist($user);
        }
    
        $manager->flush();
      }
}

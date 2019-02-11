<?php

namespace App\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;

class AdvertHandler 
{
    private $security;
    private $ObjectManager;

    public function __construct(Security $security, ObjectManager $ObjectManager){
        $this->security = $security;
        $this->ObjectManager = $ObjectManager;
    }
    public function handle(FormInterface $form, Request $request)
    {
        //dd($this->security->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //dd($request);
            $advert = $form->getData();

            $advert->setAuthor($this->security->getUser());
            
            foreach($advert->getAdvertSkills() as $advertSkill){
                
                $advertSkill->setAdvert($advert);
            }

            //$em = $this->getDoctrine()->getManager();

            $this->ObjectManager->persist($advert);

            $this->ObjectManager->flush();

           
                 
            return true;
        }

        return false;
    }

   
}

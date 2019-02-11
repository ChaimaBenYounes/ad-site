<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/application", name="app_application")
     */
    public function index()
    {
        return $this->render('application/index.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }

     /**
     * @Route("/application/{id}", name="app_application_view")
     */
    public function viewAdvert(EntityManagerInterface $em, Advert $advert)
    {
        /*if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$advert->getId()." n'existe pas.");
        }*/

        $listApplication = $em->getRepository(Application::class)->findBy(['advert' => $advert]);
        
        return $this->render('application/index.html.twig');
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Advert;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/application", name="app_application")
     */
    public function index()
    {
        return $this->render('application/application.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }

     /**
     * @Route("/application/{id}", name="app_application_view")
     */
    public function viewApplication(EntityManagerInterface $em, Advert $advert)
    {

        $listApplication = $em->getRepository(Application::class)->findBy(['advert' => $advert]);
        
        return $this->render('application/application.html.twig');
    }

}

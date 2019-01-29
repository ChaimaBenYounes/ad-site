<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;


use Doctrine\ORM\EntityManagerInterface;

use App\Entity\{Advert,Image,Application};
use App\Repository\AdvertRepository;
use App\Form\{AdvertType,AdvertEditType};

class AdvertController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function showAllAdvert(EntityManagerInterface $em )
    {
        $advertsRepository = $em->getRepository(Advert::class)->findAll();

        return $this->render('Advert/advert.html.twig',[
            'adverts' => $advertsRepository
        ]);
    }

    /**
     * @Route("/advert/{id}", name="view", requirements={"id"="\d+"})
     */
    public function viewAdvert(Advert $advert)
    {
        return $this->render('Advert/viewAdvert.html.twig', [
            'advert' => $advert
        ]);

    }

    /**
     * @Route("/add", name="add")
     */
    public function addAdvert(Request $request)
    {

        $advert = new Advert();

        $form   = $this->get('form.factory')->create(AdvertType::class, $advert);
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $advert = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
      
      
                return $this->redirectToRoute('view', ['id' => $advert->getId()]);
        }


        return $this->render('Advert/addAdvert.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function editAdvert(Advert $advert,Request $request, $id)
    {
        
        $form   = $this->get('form.factory')->create(AdvertEditType::class, $advert);
        $form = $this->createForm(AdvertEditType::class, $advert);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

        
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
      
                return $this->redirectToRoute('view', ['id' => $advert->getId()]);
            
        }
        return $this->render('Advert/addAdvert.html.twig',[
            'form' => $form->createView()
        ]);
       

    }
     
    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function deleteAdvert(AdvertRepository $advertsRepository, EntityManagerInterface $em, Advert $advert )
    {
        $ad = $advertsRepository->find($advert->getId());
        
        if (!$advertsRepository) {
            throw $this->createNotFoundException(
                'No product found for id '.$advert->getId()
            );
        }

        $em->remove($ad);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/postuler/{id}", name="postuler", requirements={"id"="\d+"})
     */
    public function postulerAdvert(AdvertRepository $advertsRepository, EntityManagerInterface $em, Advert $advert )
    {
        $ad = $advertsRepository->find($advert->getId());
        
        if (!$advertsRepository) {
            throw $this->createNotFoundException(
                'No product found for id '.$advert->getId()
            );
        }
        
        // Candidature 1
        $application1 = new Application();
        $application1->setAuthor('MarMicheakine');
        $application1->setContent("dddd");
        $application1->setDate( new \Datetime());
         // Candidature 2
         $application2 = new Application();
         $application2->setAuthor('Alain');
         $application2->setContent("ddddd");
         $application2->setDate( new \Datetime());
         

         
         $application1->setAdvert($advert);
         $application2->setAdvert($advert);

         
         $em->persist($application1);
         $em->persist($application2);


        $em->flush();

        return new Response('ok');
    }

}
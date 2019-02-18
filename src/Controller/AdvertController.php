<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\{Advert, Image, Application, Skill, AdvertSkill, Category};
use App\Repository\AdvertRepository;
use App\Form\{AdvertType, AdvertEditType, SkillType, AdvertSkillType };
use App\Handler\AdvertHandler;

class AdvertController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function showAllAdvert(EntityManagerInterface $em, Request $request, PaginatorInterface $paginatorInterface )
    {
        $advertsRepository = $em->getRepository(Advert::class)->findByPublishedTrue();

        $pagination = $paginatorInterface->paginate(
            $advertsRepository,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('Advert/advert.html.twig',[
            'adverts' => $advertsRepository,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/advert/{id}", name="view", requirements={"id"="\d+"})
     */
    public function viewAdvert(EntityManagerInterface $em, Advert $advert)
    {
        $listAdvertSkills = $em->getRepository(AdvertSkill::class)->findBy(['advert' => $advert]);
        return $this->render('Advert/viewAdvert.html.twig', [
            'advert' => $advert,
            'listAdvertSkills' => $listAdvertSkills
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addAdvert(Request $request, AdvertHandler $handler )
    {
        $advert = new Advert();

        // Cette date sera donc préaffichée dans le formulaire, cela facilite le travail de l'utilisateur
        $advert->setDate(new \Datetime());

        //$form   = $this->get('form.factory')->create(AdvertType::class, $advert);
        //Methode raccourcie
        $form = $this->createForm(AdvertType::class, $advert);
        
        if($handler->handle($form, $request)){  
            
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            ); 
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
        $form = $this->createForm(AdvertEditType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
      
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
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\{Advert, Image, Application, Skill, AdvertSkill};
use App\Repository\AdvertRepository;
use App\Form\{AdvertType, AdvertEditType, SkillType, AdvertSkillType };

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
    public function viewAdvert(EntityManagerInterface $em, Advert $advert)
    {
        /*if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$advert->getId()." n'existe pas.");
        }*/

        $listAdvertSkills = $em->getRepository(AdvertSkill::class)->findBy(['advert' => $advert]);
        
        return $this->render('Advert/viewAdvert.html.twig', [
            'advert' => $advert,
            'listAdvertSkills' => $listAdvertSkills
        ]);

    }

    /**
     * @Route("/add", name="add")
     */
    public function addAdvert(Request $request)
    {

        $advert = new Advert();
        //$advertSkill = new AdvertSkill();
        //$advertSkill->setAdvert($advert->getId());

        // Cette date sera donc préaffichée dans le formulaire, cela facilite le travail de l'utilisateur
        $advert->setDate(new \Datetime());

        //$form   = $this->get('form.factory')->create(AdvertType::class, $advert);
        //Methode raccourcie 
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $advert = $form->getData();

            foreach($advert->getAdvertSkills() as $advertSkill){
                
                $advertSkill->setAdvert($advert);
            }
            
            //dd($advert->getAdvertSkills(), $advert, $request);
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

    /**
     * @Route("/load", name="load")
     */
    public function loadTest(ObjectManager $manager)
    {
        $adverts = $advertsRepository = $manager->getRepository(Advert::class)->findAll();
        $skills = $advertsRepository = $manager->getRepository(Skill::class)->findAll();
        $level = ['Débutant', 'Avisé ', 'Expert'];

        //var_dump($level[array_rand($level)]); die();

        for ($i=1; $i < 30; $i++) {
            $advertSkill = new AdvertSkill();
            $advertSkill->setLevel($level[array_rand($level)]);
            $advertSkill->setAdvert($adverts[array_rand($adverts)]);
            $advertSkill->setSkill($skills[array_rand($skills)]);

            $manager->persist($advertSkill);
        }
       
        $manager->flush();

        return new Response('ok');
    }

}
<?php

namespace App\Controller\admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class AdminController extends EasyAdminController
{
    /**
     * @Route("/admineeee", name="admineeee")
     */
    public function index()
    {
        return $this->render('admin/account.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}

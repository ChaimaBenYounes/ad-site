<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends EasyAdminController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/account.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}

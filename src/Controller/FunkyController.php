<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FunkyController extends AbstractController
{
    /**
     * @param $first        The first number to add
     * @param $seconde      The seconde number to add
     * @return JsonResponse
     */
    public function showAllAdvert($first, $seconde)
    {
        $moyenne = $first + $seconde / 2;
        return new JsonResponse();
    }
}
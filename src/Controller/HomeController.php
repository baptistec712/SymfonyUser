<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', 'home.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Home/home.html.twig');
    }
}
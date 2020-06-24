<?php

declare(strict_types=1);

namespace App\UI\Http\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}

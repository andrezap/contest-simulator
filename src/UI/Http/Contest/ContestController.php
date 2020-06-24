<?php

declare(strict_types=1);

namespace App\UI\Http\Contest;

use App\Domain\Contest\Contest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContestController extends AbstractController
{
    private EntityManagerInterface $entity;

    public function __construct(EntityManagerInterface $entity)
    {
        $this->entity = $entity;
    }

    public function index(): Response
    {
        $contest = new Contest();

        $this->entity->persist($contest);
        $this->entity->flush();
//        return $this->render('index.html.twig');
    }
}

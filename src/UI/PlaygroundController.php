<?php

declare(strict_types=1);

namespace App\UI;

use App\Domain\Contest\Contest;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PlaygroundController extends AbstractController
{
    private ContestantRepositoryInterface $contestantRepository;
    private EntityManagerInterface $entity;

    public function __construct(ContestantRepositoryInterface $contestantRepository, EntityManagerInterface $entity)
    {
        $this->contestantRepository = $contestantRepository;
        $this->entity               = $entity;
    }

    public function play(): Response
    {
        $contest = $this->entity->find(Contest::class, 'f928d610-19df-4c49-ada3-b961fc24ec71');
        $winner  = $this->contestantRepository->findHighestScoreForContest($contest);
        \dump($winner);

        return new Response($winner);
    }
}

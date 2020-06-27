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

    /**
     * @var ContestantRepositoryInterface
     */
    private ContestantRepositoryInterface $contestantRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entity;

    public function __construct(ContestantRepositoryInterface $contestantRepository, EntityManagerInterface $entity)
    {
        $this->contestantRepository = $contestantRepository;
        $this->entity               = $entity;
    }

    public function play() : Response
    {
        $contest = $this->entity->find(Contest::class, '751c2093-1166-4b53-bbab-764b5c755971');
        $winner  = $this->contestantRepository->findHighestScoreForContest($contest);
        dump($winner);

        return new Response($winner);
    }
}

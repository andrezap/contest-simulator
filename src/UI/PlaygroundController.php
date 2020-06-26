<?php

declare(strict_types=1);

namespace App\UI;

use App\Domain\Contest\Contest;
use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use App\Domain\Judge\JudgeType;
use App\Util\SearchMultidimensionalArray;
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
        $this->entity = $entity;
    }

    public function play(): Response
    {
        $contest = $this->entity->find(Contest::class, '8026407b-d591-45af-b659-d37a544801d3');
        $winner = $this->contestantRepository->findWinner($contest);
        dump($winner);
        return new Response($winner);
    }
}

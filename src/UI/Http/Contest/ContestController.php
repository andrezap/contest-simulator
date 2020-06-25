<?php

declare(strict_types=1);

namespace App\UI\Http\Contest;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Service\CreateNewContest;
use App\Domain\Round\Service\PlayRound;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ContestController extends AbstractController
{
    private CreateNewContest $createNewContest;

    private PlayRound $playRound;

    public function __construct(CreateNewContest $createNewContest, PlayRound $playRound)
    {
        $this->createNewContest = $createNewContest;
        $this->playRound        = $playRound;
    }

    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    public function create(): RedirectResponse
    {
        try {
            $contest = $this->createNewContest->execute();
        } catch (\Throwable $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );

            return $this->redirectToRoute('home');
        }

        return $this->redirectToRoute('contest_view', [
            'id' => $contest->id()->toString(),
        ]);
    }

    /**
     * @ParamConverter("contest", class="App\Domain\Contest\Contest")
     */
    public function view(ContestInterface $contest): Response
    {
        return $this->render('contest.html.twig', ['contest' => $contest]);
    }

    /**
     * @ParamConverter("contest", class="App\Domain\Contest\Contest")
     */
    public function nextRound(ContestInterface $contest): Response
    {
        if ($contest->isDone()) {
            return $this->render('finish.html.twig', ['contest' => $contest]);
        }

        try {
            $this->playRound->execute($contest);
        } catch (\Throwable $exception) {
            return $this->render('error.html.twig', [
                'message' => $exception->getMessage(),
            ]);
        }

        return $this->render('round.html.twig', ['contest' => $contest]);
    }
}

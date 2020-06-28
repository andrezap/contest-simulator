<?php

declare(strict_types=1);

namespace App\UI\Http\Contest;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Service\CreateNewContest;
use App\Domain\Contest\Service\FinishContest;
use App\Domain\Round\Service\PlayRound;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ContestController extends AbstractController
{
    private CreateNewContest $createNewContest;

    private PlayRound $playRound;

    private FinishContest $finishContest;

    public function __construct(CreateNewContest $createNewContest, PlayRound $playRound, FinishContest $finishContest)
    {
        $this->createNewContest = $createNewContest;
        $this->playRound        = $playRound;
        $this->finishContest    = $finishContest;
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
        try {
            $round = $this->playRound->execute($contest);
        } catch (\Throwable $exception) {
            return $this->render('error.html.twig', [
                'message' => $exception->getMessage(),
            ]);
        }

        if ($round->isLastRound()) {
            $winner = $this->finishContest->execute($contest);

            return $this->render('finish.html.twig', ['contest' => $contest, 'winner' => $winner]);
        }

        return $this->render('round.html.twig', ['contest' => $contest]);
    }
}

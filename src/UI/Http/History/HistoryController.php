<?php

declare(strict_types=1);

namespace App\UI\Http\History;

use App\Domain\History\Service\CreateHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HistoryController extends AbstractController
{
    private CreateHistory $history;

    public function __construct(CreateHistory $history)
    {
        $this->history = $history;
    }

    public function show(): Response
    {
        $history = $this->history->execute();

        return $this->render('history.html.twig', ['history' => $history]);
    }
}

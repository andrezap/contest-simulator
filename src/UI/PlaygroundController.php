<?php

declare(strict_types=1);

namespace App\UI;

use App\Domain\Contestant\Contestant;
use App\Util\SearchMultidimensionalArray;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaygroundController extends AbstractController
{
    private EntityManagerInterface $entity;

    public function __construct(EntityManagerInterface $entity)
    {
        $this->entity = $entity;
    }

    public function play(): void
    {
        $c = $this->entity->find(Contestant::class, '613ea8c0-c557-4b18-bba5-fa9ad0bdc8f7');
        \assert($c instanceof Contestant);
        $array = $c->genreStrengths();
        \dump($array);
        $found_key = SearchMultidimensionalArray::searchKey($array, 'POP');
        \dump($found_key);
    }
}

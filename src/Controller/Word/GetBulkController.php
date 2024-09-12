<?php

namespace App\Controller\Word;

use App\Cqrs\Query\Word\GetWordBulk;
use App\Cqrs\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class GetBulkController extends AbstractController
{
    #[Route('/word', name: 'get_word_bulk', methods: 'GET')]
    public function __invoke(QueryBus $queryBus): Response
    {
        return new Response(
            $queryBus->handle(new GetWordBulk()),
            Response::HTTP_OK
        );
    }
}

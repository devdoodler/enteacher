<?php

namespace App\Controller\Word;

use App\Cqrs\Query\Word\GetWord;
use App\Cqrs\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class GetController extends AbstractController
{
    #[Route('/word/{id}', name: 'get_word', methods: 'GET')]
    public function __invoke(int $id, QueryBus $queryBus): Response
    {
        return new Response(
            $queryBus->handle(new GetWord($id)),
            Response::HTTP_OK
        );
    }
}

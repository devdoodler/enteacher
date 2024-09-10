<?php

namespace App\Controller\Pronunciation;

use App\Cqrs\Query\Word\GetPronunciation;
use App\Cqrs\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class GetController extends AbstractController
{
    #[Route('/pronunciation/{id}', name: 'get_pronunciation', methods: 'GET')]
    public function __invoke(int $id, QueryBus $queryBus): Response
    {
        return new Response(
            $queryBus->handle(new GetPronunciation($id)),
            Response::HTTP_OK
        );
    }
}

<?php

namespace App\Controller\Word;


use App\Cqrs\Command\Word\RemoveWord;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RemoveController extends AbstractController
{
    #[Route('/word/{id}', name: 'remove_word', methods: 'DELETE')]
    public function __invoke(int $id, CommandBus $messageBus): Response
    {
        $messageBus->dispatch(new RemoveWord($id));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}

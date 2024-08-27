<?php

namespace App\Controller\Word;

use App\Cqrs\Command\Word\AddWord;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


class AddController extends AbstractController
{
    #[Route('/word', name: 'add_word', methods: 'POST')]
    public function __invoke(#[MapRequestPayload] AddWord $addWord, CommandBus $messageBus): Response
    {
        $messageBus->dispatch($addWord);

        return new Response('', Response::HTTP_ACCEPTED);
    }
}

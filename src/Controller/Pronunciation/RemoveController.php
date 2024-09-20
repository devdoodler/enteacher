<?php

namespace App\Controller\Pronunciation;

use App\Cqrs\Command\Pronunciation\RemovePronunciation;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RemoveController extends AbstractController
{
    #[Route('/pronunciation/{id}', name: 'remove_pronunciation', methods: 'DELETE')]
    public function __invoke(int $id, CommandBus $messageBus): Response
    {
        $messageBus->dispatch(new RemovePronunciation($id));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
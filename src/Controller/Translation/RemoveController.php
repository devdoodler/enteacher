<?php

namespace App\Controller\Translation;


use App\Cqrs\Command\Translation\RemoveTranslation;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RemoveController extends AbstractController
{
    #[Route('/translation/{id}', name: 'remove_translation', methods: 'DELETE')]
    public function __invoke(int $id, CommandBus $messageBus): Response
    {
        $messageBus->dispatch(new RemoveTranslation($id));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}

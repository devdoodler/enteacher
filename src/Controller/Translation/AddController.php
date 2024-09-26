<?php

namespace App\Controller\Translation;

use App\Cqrs\Command\Translation\AddTranslation;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


class AddController extends AbstractController
{
    #[Route('/translation', name: 'add_translation', methods: 'POST')]
    public function __invoke(#[MapRequestPayload] AddTranslation $addTranslation, CommandBus $messageBus): Response
    {
        $messageBus->dispatch($addTranslation);

        return new Response('', Response::HTTP_CREATED);
    }
}

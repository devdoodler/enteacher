<?php

namespace App\Controller\Word;

use App\Cqrs\Command\Word\EditWord;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


class EditController extends AbstractController
{
    #[Route('/word/{id}', name: 'edit_word', methods: 'PUT')]
    public function __invoke(#[MapRequestPayload] EditWord $editWord, Request $request, CommandBus $messageBus): Response
    {
        $editWord->id = $request->get("id");
        $messageBus->dispatch($editWord);

        return new Response('', Response::HTTP_ACCEPTED);
    }
}

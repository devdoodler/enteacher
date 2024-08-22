<?php

namespace App\Controller\Word;

use App\Dto\WordAddDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;


class WordController extends AbstractController
{
    #[Route('/word', name: 'add_word', methods: 'POST')]
    public function __invoke(#[MapRequestPayload] WordAddDto $addWord): Response
    {
        return new Response('', Response::HTTP_ACCEPTED);
    }
}

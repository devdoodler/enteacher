<?php

namespace App\Controller\Pronunciation;

use App\Cqrs\Command\Pronunciation\AddPronunciation;
use App\Cqrs\CommandBus;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AddController extends AbstractController
{
    #[Route('/pronunciation', name: 'add_pronunciation', methods: 'POST')]
    public function __invoke(
        #[MapRequestPayload] AddPronunciation $addPronunciation,
        Request $request,
        CommandBus $messageBus,
        FileService $fileService,
        #[Autowire('%kernel.project_dir%/public/uploads/voice')] string $voiceDir
    ): Response
    {
        $file = $request->files->getIterator()['voice'];

        if ($file) {
            $newFileName = $fileService->addFile($file, $voiceDir);
        }
        if (isset($newFileName) && $newFileName) {
            $addPronunciation->setPath($newFileName);
        }

        $messageBus->dispatch($addPronunciation);

        return new Response('', Response::HTTP_CREATED);
    }
}

<?php

namespace App\Controller\Pronunciation;

use App\Cqrs\Command\Pronunciation\AddPronunciation;
use App\Cqrs\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddController extends AbstractController
{
    #[Route('/pronunciation', name: 'add_pronunciation', methods: 'POST')]
    public function __invoke(
        #[MapRequestPayload] AddPronunciation $addPronunciation,
        Request $request,
        SluggerInterface $slugger,
        CommandBus $messageBus,
        #[Autowire('%kernel.project_dir%/public/uploads/voice')] string $voiceDir
    ): Response
    {
        $file = $request->files->getIterator()['voice'];
        if ($file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFileName = $slugger->slug($originalName) . uniqid() . '.' . $file->guessExtension();
            try {
                $file->move($voiceDir, $newFileName);
            } catch (FileException $e) {
            }
        }

        if (isset($newFileName)) {
            $addPronunciation->setPath($newFileName);
        }

        $messageBus->dispatch($addPronunciation);

        return new Response('', Response::HTTP_CREATED);
    }
}

<?php

namespace App\Service;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly Filesystem $filesystem,
        #[Autowire('%kernel.project_dir%/public/uploads/')] private readonly string $pathPrefix
    ) { }

    public function addFile(UploadedFile $file, string $path): ?string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $this->slugger->slug($originalName) . uniqid() . '.' . $file->guessExtension();
        try {
            $file->move($path, $newFileName);
        } catch (FileException $e) {
            return null;
        }

        return $newFileName;
    }

    public function cleanFile(string $path, $fileName): bool
    {
        $path = $this->pathPrefix . $path . '/' . $fileName;

        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);

            return true;
        }

        return false;
    }
}

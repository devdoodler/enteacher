<?php

namespace App\Cqrs\Command\Pronunciation;

use App\Cqrs\Command;
use App\Dto\Assert;

final class AddPronunciation implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        public string $wordId,

        #[Assert\NotBlank]
        public string $dialect,

        #[Assert\NotBlank]
        public string $source,

        public string $path,

        public ?string $phonetically
    ) {
    }

    public function setPath(string $path): AddPronunciation
    {
        $this->path = $path;
        return $this;
    }
}
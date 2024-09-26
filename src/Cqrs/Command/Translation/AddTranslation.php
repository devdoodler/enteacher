<?php

namespace App\Cqrs\Command\Translation;

use App\Cqrs\Command;
use App\Dto\Assert;

final readonly class AddTranslation implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        public int $wordId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        public ?string $explanation
    ) {
    }
}
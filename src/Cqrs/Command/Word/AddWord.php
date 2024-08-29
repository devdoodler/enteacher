<?php

namespace App\Cqrs\Command\Word;

use App\Cqrs\Command;
use App\Dto\Assert;

final readonly class AddWord implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $name,

        #[Assert\NotBlank]
        public string $dialect,

        public ?string $explanation,

        public ?string $pronunciation
    ) {
    }
}
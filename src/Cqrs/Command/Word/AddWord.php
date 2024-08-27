<?php

namespace App\Cqrs\Command\Word;

use App\Cqrs\Command;
use App\Dto\Assert;
use App\Enum\DialectEnum;

final class AddWord implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public readonly string $name,

        #[Assert\NotBlank]
        public readonly string $dialect,

        public readonly ?string $explanation,

        public readonly ?string $pronunciation
    ) {
    }
}
<?php

namespace App\Cqrs\Command\Word;

use App\Cqrs\Command;
use App\Dto\Assert;

final class EditWord implements Command
{
    public function __construct(
        public ?int $id,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public readonly string  $name,

        #[Assert\NotBlank]
        public readonly string  $dialect,

        public readonly ?string $explanation,

        public readonly ?string $pronunciation
    ) {
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
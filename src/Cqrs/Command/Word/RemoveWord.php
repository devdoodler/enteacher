<?php

namespace App\Cqrs\Command\Word;

use App\Cqrs\Command;
use App\Dto\Assert;

final readonly class RemoveWord implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        public int  $id
    ) {
    }
}
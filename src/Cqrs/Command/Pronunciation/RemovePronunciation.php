<?php

namespace App\Cqrs\Command\Pronunciation;

use App\Cqrs\Command;
use App\Dto\Assert;

final readonly class RemovePronunciation implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        public int  $id
    ) {
    }
}
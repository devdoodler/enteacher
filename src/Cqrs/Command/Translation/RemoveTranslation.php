<?php

namespace App\Cqrs\Command\Translation;

use App\Cqrs\Command;
use App\Dto\Assert;

final readonly class RemoveTranslation implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        public int  $id
    ) {
    }
}
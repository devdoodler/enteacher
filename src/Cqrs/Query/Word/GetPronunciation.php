<?php

namespace App\Cqrs\Query\Word;

use App\Cqrs\Query;
use App\Dto\Assert;

final readonly class GetPronunciation implements Query
{
    public function __construct(
        #[Assert\NotBlank]
        public int  $id
    ) {
    }
}
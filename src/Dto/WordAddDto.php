<?php

namespace App\Dto\Input;

final class WordAddDto
{
    public string $name;

    public int $dialect;

    public ?string $explanation;

    public ?string $pronunciation;
}
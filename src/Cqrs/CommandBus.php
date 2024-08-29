<?php

namespace App\Cqrs;

interface CommandBus
{
    public function dispatch(Command $command): void;
}

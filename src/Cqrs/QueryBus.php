<?php

namespace App\Cqrs;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}

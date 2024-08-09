<?php

namespace Darko\FilamentContentToolkits\Model\Contracts;

interface Relatable
{
    public function getRelated(string $type);
}

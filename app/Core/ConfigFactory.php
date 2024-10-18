<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Utils\Arrays;

class ConfigFactory
{
    public array $parameters;

    public function __construct(...$args)
    {
        Arrays::toObject($args, $this);
    }
}

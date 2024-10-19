<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Utils\Arrays;

class ConfigFactory
{
    /**
     * @var array<string, mixed>
     */
    public array $parameters;

    /**
     * @param array<string, mixed> $args
     */
    public function __construct(...$args)
    {
        Arrays::toObject($args, $this);
    }
}

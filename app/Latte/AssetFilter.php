<?php

namespace App\Latte;

use Nette\Utils\JsonException;
use Vite;

class AssetFilter
{
    public function __construct(
        private Vite $vite,
    ) {}

    /**
     * @throws JsonException
     */
    public function __invoke(string $path): string
    {
        return $this->vite->getAsset($path);
    }
}

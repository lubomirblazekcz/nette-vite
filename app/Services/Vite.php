<?php

use Nette\Utils\FileSystem;
use Nette\Utils\Html;
use Nette\Utils\Json;
use Nette\Http\Request;


class Vite
{
    public function __construct(
        private string $viteServer,
        private string $manifestFile,
        private bool $productionMode,
        private Request $httpRequest,
    ){}

    /**
     * @throws \Nette\Utils\JsonException
     */
    public function getAsset(string $entrypoint): string
    {
        $asset = '';
        $baseUrl = '/';

        if (!$this->isEnabled()) {
            if (file_exists($this->manifestFile)) {
                $manifest = Json::decode(FileSystem::read($this->manifestFile), Json::FORCE_ARRAY);
                $asset = $manifest[$entrypoint]['file'];
            } else {
                trigger_error('Missing manifest file: ' . $this->manifestFile, E_USER_WARNING);
            }

        } else {
            $baseUrl = $this->viteServer . '/';
            $asset = $entrypoint;
        }

        return $baseUrl . $asset;
    }

    /**
     * @throws \Nette\Utils\JsonException
     */
    public function getCssAssets(string $entrypoint): array
    {
        $assets = [];
        $baseUrl = '/';

        if (!$this->isEnabled()) {
            if (file_exists($this->manifestFile)) {
                $manifest = Json::decode(FileSystem::read($this->manifestFile), Json::FORCE_ARRAY);
                foreach ($manifest[$entrypoint]['css'] ?? [] as $asset) {
                    $assets[] = $baseUrl . $asset;
                }
            } else {
                trigger_error('Missing manifest file: ' . $this->manifestFile, E_USER_WARNING);
            }

        }

        return $assets;
    }

    public function isEnabled(): bool
    {
        if (!$this->productionMode && $this->httpRequest->getCookie('netteVite') === 'true') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \Nette\Utils\JsonException
     */
    public function printTags(string $entrypoint): void
    {
        $scripts = [$this->getAsset($entrypoint)];
        $styles = $this->getCssAssets($entrypoint);

        if ($this->isEnabled()) {
            echo Html::el('script')->type('module')->src($this->viteServer . '/' . '@vite/client');
        }

        foreach ($styles as $path) {
            echo Html::el('link')->rel('stylesheet')->href($path);
        }

        foreach ($scripts as $path) {
            echo Html::el('script')->type('module')->src($path);
        }
    }
}

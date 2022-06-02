<?php declare(strict_types=1);

namespace MMEE\Vite;

use Nette\Utils\FileSystem;
use Nette\Utils\Html;
use Nette\Utils\Json;
use Nette\Http\Request;

final class Service
{
	private string $viteServer;

	private string $manifestFile;

	private bool $debugMode;

	private Request $httpRequest;


	public function __construct(string $viteServer, string $manifestFile, bool $debugMode, Request $httpRequest)
	{
		$this->viteServer = $viteServer;
		$this->manifestFile = $manifestFile;
		$this->debugMode = $debugMode;
		$this->httpRequest = $httpRequest;
	}


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


	public function getCssAssets(string $entrypoint): array
	{
		$assets = [];

		if (!$this->isEnabled()) {
			if (file_exists($this->manifestFile)) {
				$manifest = Json::decode(FileSystem::read($this->manifestFile), Json::FORCE_ARRAY);
				$assets = $manifest[$entrypoint]['css'] ?? [];
			} else {
				trigger_error('Missing manifest file: ' . $this->manifestFile, E_USER_WARNING);
			}
		}

		return $assets;
	}


	public function isEnabled(): bool
	{
		return $this->debugMode && $this->httpRequest->getCookie('netteVite') === 'true';
	}


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

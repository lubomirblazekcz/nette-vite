<?php declare(strict_types=1);

namespace MMEE\Vite\Nette;

use MMEE\Vite\AssetFilter;
use MMEE\Vite\ManifestFileDoesNotExistsException;
use MMEE\Vite\Service;
use MMEE\Vite\Tracy\VitePanel;
use Nette;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions;
use Nette\Schema;
use Tracy;

/**
 * @property \stdClass $config
 */
final class Extension extends CompilerExtension
{

	public function getConfigSchema(): Schema\Schema
	{
		return Schema\Expect::structure([
			'server' => Schema\Expect::string('http://localhost:3000'),
			'debugMode' => Schema\Expect::bool($this->getContainerBuilder()->parameters['debugMode'] ?? false),
			'manifestFile' => Schema\Expect::string(),
			'filterName' => Schema\Expect::string('asset'), // empty string is for disabled
			'templateProperty' => Schema\Expect::string('_vite'), // empty string is for disabled
			'wwwDir' => Schema\Expect::string($this->getContainerBuilder()->parameters['wwwDir'] ?? getcwd()),
			'basePath' => Schema\Expect::string(),
		]);
	}


	public function loadConfiguration(): void
	{
		$this->buildViteService();
		$this->buildFilter();
	}


	private function buildViteService(): void
	{
		$manifestFile = $this->prepareManifestPath();
		$this->getContainerBuilder()->addDefinition($this->prefix('service'))
			->setFactory(Service::class)
			->setArguments([
				'viteServer' => $this->config->server,
				'manifestFile' => $manifestFile,
				'debugMode' => $this->config->debugMode,
				'basePath' => $this->prepareBasePath($manifestFile),
			]);
	}


	private function buildFilter(): void
	{
		$this->getContainerBuilder()->addDefinition($this->prefix('assetFilter'))
			->setFactory(AssetFilter::class)
			->setAutowired(false);
	}


	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		$templateFactoryDefinition = $builder->getDefinition('latte.templateFactory');
		assert($templateFactoryDefinition instanceof Definitions\ServiceDefinition);

		if ($this->config->templateProperty !== '') {
			$templateFactoryDefinition->addSetup(
				new Nette\DI\Definitions\Statement('$onCreate[]', [
					new Definitions\Statement([
						self::class,
						'prepareTemplate',
					], [$this->config->templateProperty, $builder->getDefinition($this->prefix('service'))]),
				]),
			);
		}

		if ($this->config->filterName !== '' && $builder->hasDefinition('latte.latteFactory')) {
			$definition = $builder->getDefinition('latte.latteFactory');
			assert($definition instanceof Definitions\FactoryDefinition);
			$definition->getResultDefinition()
				->addSetup('addFilter', [
					$this->config->filterName,
					$builder->getDefinition($this->prefix('assetFilter')),
				]);
		}

		$tracyClass = Tracy\Bar::class;
		if ($this->config->debugMode && $builder->getByType($tracyClass)) {
			$definition = $this->getContainerBuilder()
				->getDefinition($this->prefix('service'));
			assert($definition instanceof Definitions\ServiceDefinition);
			$definition->addSetup("@$tracyClass::addPanel", [
				new Definitions\Statement(VitePanel::class),
			]);
		}
	}


	public static function prepareTemplate(string $propertyName, Service $service): \Closure
	{
		return static function (Nette\Application\UI\Template $template) use ($propertyName, $service): void {
			$template->{$propertyName} = $service;
		};
	}


	private function prepareManifestPath(): string
	{
		if ($this->config->manifestFile === null) {
			return $this->automaticSearchManifestFile();
		}

		$manifestFile = $this->config->manifestFile;
		if (!is_file($manifestFile)) {
			$newPath = $this->config->wwwDir . DIRECTORY_SEPARATOR . ltrim($manifestFile, '/\\');
			if (!is_file($newPath)) {
				throw new ManifestFileDoesNotExistsException(sprintf('Found here "%s" or "%s".', $manifestFile, $newPath));
			}

			$manifestFile = $newPath;
		}

		return Nette\Safe::realpath($manifestFile);
	}


	private function prepareBasePath(string $manifestFile): string
	{
		if ($this->config->basePath === null) {
			return str_replace(Nette\Safe::realpath($this->config->wwwDir), '', dirname($manifestFile)) . '/';
		}

		return $this->config->basePath;
	}


	private function automaticSearchManifestFile(): string
	{
		$finder = Nette\Utils\Finder::findFiles('manifest.json')->from($this->config->wwwDir);
		$files = [];
		foreach ($finder as $file) {
			$files[] = $file->getPathname();
		}
		if ($files === []) {
			throw new ManifestFileDoesNotExistsException(sprintf('Define path to manifest.json, because automatic search found nothing in "%s".', $this->config->wwwDir));
		} elseif (count($files) > 1) {
			throw new ManifestFileDoesNotExistsException(sprintf('Define path to manifest.json, because automatic search found many manifest.json files %s.', implode(', ', $files)));
		}

		return reset($files);
	}

}

<?php declare(strict_types=1);

namespace MMEE\Vite\Nette;

use MMEE\Vite\AssetFilter;
use MMEE\Vite\Service;
use MMEE\Vite\Tracy\VitePanel;
use Nette\DI\CompilerExtension;
use Nette;
use Nette\Schema;
use Nette\DI\Definitions;
use Tracy;

final class Extension extends CompilerExtension
{

	public function getConfigSchema(): Schema\Schema
	{
		return Schema\Expect::structure([
			'server' => Schema\Expect::string('http://localhost:3000'),
			'debugMode' => Schema\Expect::bool($this->getContainerBuilder()->parameters['debugMode'] ?? false),
			'manifestFile' => Schema\Expect::string()->required(),
			'filterName' => Schema\Expect::string('asset'), // empty string is for disabled
			'templateProperty' => Schema\Expect::string('_vite'), // empty string is for disabled and you can use ViteToTemplate for Presenter
		]);
	}


	public function loadConfiguration(): void
	{
		$this->buildViteService();
		$this->buildFilter();
	}


	private function buildViteService(): void
	{
		$this->getContainerBuilder()->addDefinition($this->prefix('service'))
			->setFactory(Service::class)
			->setArguments([
				'viteServer' => $this->config->server,
				'manifestFile' => $this->config->manifestFile,
				'debugMode' => $this->config->debugMode,
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
				])
			);
		}

		if ($this->config->filterName !== '' && $builder->hasDefinition('latte.latteFactory')) {
			$builder->getDefinition('latte.latteFactory')
				->getResultDefinition()
				->addSetup('addFilter', [
					$this->config->filterName,
					$builder->getDefinition($this->prefix('assetFilter')),
				]);
		}

		$tracyClass = Tracy\Bar::class;
		if ($this->config->debugMode && $builder->getByType($tracyClass)) {
			$this->getContainerBuilder()->getDefinition($this->prefix('service'))
				->addSetup("@$tracyClass::addPanel", [
					new Definitions\Statement(VitePanel::class),
				]);
		}
	}


	public static function prepareTemplate(string $propertyName, Service $service): \Closure
	{
		return function (Nette\Application\UI\Template $template) use ($propertyName, $service): void {
			$template->{$propertyName} = $service;
		};
	}

}

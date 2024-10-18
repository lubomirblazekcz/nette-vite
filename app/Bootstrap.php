<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;

define("ROOT_DIR", dirname(__DIR__));
define("SRC_DIR", ROOT_DIR . '/src');
define("SRC_VIEWS_DIR", ROOT_DIR . '/src/views');
define("SRC_LAYOUTS_DIR", SRC_VIEWS_DIR . '/layouts');
define("SRC_PRESENTERS_DIR", SRC_VIEWS_DIR . '/presenters');

class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;

		$configurator->setDebugMode(true);
		$configurator->enableTracy(ROOT_DIR . '/log');

		$configurator->setTempDirectory(ROOT_DIR . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig(ROOT_DIR . '/config/common.neon');
		$configurator->addConfig(ROOT_DIR . '/config/services.neon');

		return $configurator;
	}
}

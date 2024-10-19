<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;

class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator();
        $rootDir = dirname(__DIR__);
        $debug = getenv('NETTE_DEBUG');

        $configurator->setDebugMode(filter_var($debug, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $debug);
        $configurator->enableTracy($rootDir . '/log');

        $configurator->setTempDirectory($rootDir . '/temp');

        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addConfig($rootDir . '/config/common.neon');
        $configurator->addConfig($rootDir . '/config/services.neon');

        return $configurator;
    }
}

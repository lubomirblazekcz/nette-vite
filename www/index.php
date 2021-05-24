<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 70400) {
	exit('Nette Sandbox requires a PHP version 7.4 or newer. You are running ' . PHP_VERSION . '.');
}

require __DIR__ . '/../vendor/autoload.php';

App\Bootstrap::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();

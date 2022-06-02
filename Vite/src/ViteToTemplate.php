<?php declare(strict_types=1);

namespace MMEE\Vite;

trait ViteToTemplate
{

	final public function injectVite(Service $vite): void
	{
		$this->onRender[] = static fn($presenter) => $presenter->getTemplate()->_vite = $vite;
	}

}

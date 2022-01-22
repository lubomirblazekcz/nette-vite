<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Vite;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Vite $vite,
    ) {}

    public function beforeRender(): void
    {
        $this->template->vite = $this->vite;
    }
}

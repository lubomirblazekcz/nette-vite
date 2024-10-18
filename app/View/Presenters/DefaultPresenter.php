<?php

declare(strict_types=1);

namespace App\View\Presenters;

use Nette;


class DefaultPresenter extends Nette\Application\UI\Presenter
{
    protected function startup(): void
    {
        parent::startup();

        $this->setLayout(SRC_DIR . '/views/layouts/default.latte');
    }
}

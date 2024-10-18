<?php

declare(strict_types=1);

namespace App\View\Presenters;

use Nette;
use Nette\Application\Helpers;


class DefaultPresenter extends Nette\Application\UI\Presenter
{
    public function formatTemplateFiles(): array
    {
        [, $presenter] = Helpers::splitName($this->getName());

        return [
            SRC_PRESENTERS_DIR . "/$presenter/$this->view.latte",
            SRC_PRESENTERS_DIR . "/$presenter.$this->view.latte",
        ];
    }

    public function formatLayoutTemplateFiles(): array
    {

        $layout = $this->layout ?: 'default';
        $list[] = SRC_LAYOUTS_DIR . "/$layout.latte";

        bdump($list);

        return $list;
    }
}

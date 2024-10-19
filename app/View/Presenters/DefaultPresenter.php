<?php

declare(strict_types=1);

namespace App\View\Presenters;

use App\Core\ConfigFactory;
use Nette;
use Nette\Application\Helpers;

class DefaultPresenter extends Nette\Application\UI\Presenter
{
    /** @inject */
    public ConfigFactory $config;

    public function formatTemplateFiles(): array
    {
        [, $presenter] = Helpers::splitName($this->getName());

        return [
            $this->config->parameters['srcPresentersDir'] . "/$presenter/$this->view.latte",
            $this->config->parameters['srcPresentersDir'] . "/$presenter.$this->view.latte",
        ];
    }

    public function formatLayoutTemplateFiles(): array
    {

        $layout = $this->layout ?: 'default';
        $list[] = $this->config->parameters['srcLayoutsDir'] . "/$layout.latte";

        return $list;
    }
}

<?php

declare(strict_types=1);

namespace App\Presentation\Presenters;

use App\Core\ConfigFactory;
use Nette;
use Nette\Application\Helpers;
use Nette\DI\Attributes\Inject;

class DefaultPresenter extends Nette\Application\UI\Presenter
{
    #[Inject]
    public ConfigFactory $config;

    public function formatTemplateFiles(): array
    {
        [, $presenter] = Helpers::splitName($this->getName() ?? '');

        $view = $presenter . ucfirst($this->view);

        return [
            $this->config->parameters['viewsPresentersDir'] . "/$presenter/$view.latte",
            $this->config->parameters['viewsPresentersDir'] . "/$view.latte",
        ];
    }

    public function formatLayoutTemplateFiles(): array
    {

        $layout = $this->layout ?: 'default';
        $list[] = $this->config->parameters['viewsLayoutsDir'] . "/$layout.latte";

        return $list;
    }
}

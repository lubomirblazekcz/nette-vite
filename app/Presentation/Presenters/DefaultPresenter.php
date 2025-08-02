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

        $dir = $this->config->parameters['viewsPresentersDir'] ?? null;
        $view = $presenter . ucfirst($this->view);

        return [
            (is_string($dir) ? $dir : __DIR__) . "/$presenter/$view.latte",
            (is_string($dir) ? $dir : __DIR__) . "/$view.latte",
        ];
    }

    public function formatLayoutTemplateFiles(): array
    {

        $dir = $this->config->parameters['viewsLayoutsDir'] ?? null;
        $layout = $this->layout ?: 'default';
        $list = [];

        if (!is_string($dir)) {
            return parent::formatLayoutTemplateFiles();
        }

        $list[] = "/$dir/$layout.latte";

        return $list;
    }
}

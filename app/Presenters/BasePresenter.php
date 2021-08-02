<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function renderDefault(): void
    {
        if (\Tracy\Debugger::$productionMode && file_exists(__DIR__ . '/../../www/manifest.json')) {
            $this->template->manifest = Nette\Utils\Json::decode(file_get_contents(__DIR__ . '/../../www/manifest.json'),1);
        }
    }
}

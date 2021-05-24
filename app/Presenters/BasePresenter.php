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
        if (\Tracy\Debugger::$productionMode && file_exists($_SERVER['DOCUMENT_ROOT'] . '/manifest.json')) {
            $this->template->manifest = Nette\Utils\Json::decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/manifest.json'),1);
        }
    }
}

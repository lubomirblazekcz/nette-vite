<?php

declare(strict_types=1);

namespace App\View\Presenters;

final class HomePresenter extends DefaultPresenter
{
    protected function startup(): void
    {
        parent::startup();

        $this->template->setFile(SRC_DIR . '/views/presenters/Home/default.latte');
    }
}

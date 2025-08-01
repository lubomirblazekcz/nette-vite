<?php

declare(strict_types=1);

namespace App\Presentation\Presenters\Home;

use App\Presentation\Presenters\DefaultPresenter;

final class HomePresenter extends DefaultPresenter
{
    public function beforeRender(): void
    {
        //$this->setView('Detail');
    }
}

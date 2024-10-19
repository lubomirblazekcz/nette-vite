<?php

declare(strict_types=1);

namespace App\View\Presenters;

use App\Core\ConfigFactory;
use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\DI\Attributes\Inject;

/**
 * @property-read Template $template
 * @property int $httpCode
 */
#[Requires(methods: '*', forward: true)]
final class Error4xxPresenter extends Nette\Application\UI\Presenter
{
    #[Inject]
    public ConfigFactory $config;

    public function renderDefault(Nette\Application\BadRequestException $exception): void
    {
        // renders the appropriate error template based on the HTTP status code
        $code = $exception->getCode();

        // load template 403.latte or 404.latte or ... 4xx.latte
        $file = $this->config->parameters['srcPresentersDir'] . '/Error/Error4xx/' . $code . '.latte';
        $this->template->setFile(is_file($file) ? $file : $this->config->parameters['srcPresentersDir'] . '/Error/Error4xx/4xx.latte');

        $this->template->httpCode = $code;
        $this->template->setFile($file);
    }
}

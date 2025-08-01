<?php

declare(strict_types=1);

namespace App\Presentation\Presenters\Error\Error4xx;

use App\Core\ConfigFactory;
use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\DI\Attributes\Inject;

/**
 * Handles 4xx HTTP error responses.
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
        $file = $this->config->parameters['viewsPresentersDir'] . '/Error/Error4xx/Error' . $code . '.latte';

        $this->template->httpCode = $code;
        $this->template->setFile(is_file($file) ? $file : $this->config->parameters['viewsPresentersDir'] . '/Error/Error4xx/Error4xx.latte');
    }
}

<?php

declare(strict_types=1);

namespace App\View\Presenters;

use App\Core\ConfigFactory;
use Nette;
use Nette\Application\Attributes\Requires;
use Nette\Application\Responses;
use Nette\Http;
use Tracy\ILogger;

/**
 * Handles uncaught exceptions and errors, and logs them.
 */
#[Requires(forward: true)]
final class Error5xxPresenter implements Nette\Application\IPresenter
{
    public function __construct(
        private readonly ILogger $logger,
        private readonly ConfigFactory $config
    ) {
    }


    public function run(Nette\Application\Request $request): Nette\Application\Response
    {
        // Log the exception
        $exception = $request->getParameter('exception');
        $this->logger->log($exception, ILogger::EXCEPTION);

        // Display a generic error message to the user
        return new Responses\CallbackResponse(function (Http\IRequest $httpRequest, Http\IResponse $httpResponse): void {
            if (preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type'))) {
                require $this->config->parameters['srcPresentersDir'] . '/Error/Error5xx/500.phtml';
            }
        });
    }
}

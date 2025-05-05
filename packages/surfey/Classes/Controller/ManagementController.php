<?php

declare(strict_types=1);

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;

#[AsController]
readonly class ManagementController
{
    public function __construct(
        private UriBuilder            $uriBuilder,
        private IconFactory           $iconFactory,
        private ModuleTemplateFactory $moduleTemplateFactory
    )
    {
    }

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->moduleTemplateFactory->create($request);

        return $view->assignMultiple([])->renderResponse('Management/Overview');
    }

    public function overviewAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->moduleTemplateFactory->create($request);

        return $view
            ->assignMultiple([])
            ->renderResponse('Management/Overview');
    }
}

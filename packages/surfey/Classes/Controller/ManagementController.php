<?php

declare(strict_types=1);

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

#[AsController]
readonly class ManagementController
{
    public function __construct(
        private ModuleTemplateFactory $moduleTemplateFactory
    ) {
    }

    public function overviewAction(ServerRequestInterface $request): ResponseInterface
    {
        return $this->moduleTemplateFactory->create($request)->renderResponse('Management/Overview');
    }
}

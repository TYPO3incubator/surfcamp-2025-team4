<?php

declare(strict_types=1);

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinitionDemand;
use TYPO3Incubator\Surfey\Domain\Repository\SurfeyDefinitionRepository;
use TYPO3Incubator\Surfey\Pagination\DemandedArrayPaginator;

#[AsController]
readonly class ManagementController
{
    public function __construct(
        private ModuleTemplateFactory $moduleTemplateFactory,
        private SurfeyDefinitionRepository $surfeyDefinitionRepository,
    ) {
    }

    public function overviewAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->moduleTemplateFactory->create($request);
        $view->setTitle($this->getLanguageService()->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:management.module.title'));

        $demand = SurfeyDefinitionDemand::fromRequest($request);

        $definitions = $this->surfeyDefinitionRepository->findByDemand($demand);
        $paginator = new DemandedArrayPaginator($definitions, $demand->getPage(), $demand->getLimit(), $this->surfeyDefinitionRepository->countAll());
        $pagination = new SimplePagination($paginator);

        return $this->moduleTemplateFactory->create($request)->assignMultiple([
            'demand' => $demand,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'definitions' => $definitions,
        ])->renderResponse('Management/Overview');
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}

<?php

declare(strict_types=1);

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\MultiRecordSelection\Action;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinitionDemand;
use TYPO3Incubator\Surfey\Domain\Repository\SurfeyDefinitionRepository;
use TYPO3Incubator\Surfey\Pagination\DemandedArrayPaginator;

#[AsController]
readonly class ManagementController
{
    public function __construct(
        private ModuleTemplateFactory $moduleTemplateFactory,
        private SurfeyDefinitionRepository $surfeyDefinitionRepository,
        private UriBuilder $uriBuilder,
        private IconFactory $iconFactory,
    ){
    }

    public function overviewAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->moduleTemplateFactory->create($request);
        $view->setTitle($this->getLanguageService()->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:management.module.title'));

        $demand = SurfeyDefinitionDemand::fromRequest($request);
        $this->registerDocHeaderButtons($view, $request, $demand);;

        $definitions = $this->surfeyDefinitionRepository->findByDemand($demand);
        $paginator = new DemandedArrayPaginator($definitions, $demand->getPage(), $demand->getLimit(), $this->surfeyDefinitionRepository->countAll());
        $pagination = new SimplePagination($paginator);
        $requestUri = $request->getAttribute('normalizedParams')->getRequestUri();
        $languageService = $this->getLanguageService();

        return $view->assignMultiple([
            'demand' => $demand,
            'paginator' => $paginator,
            'pagination' => $pagination,
            'definitions' => $definitions,
            'returnUrl' => $requestUri,
            'pid' => (int)($request->getQueryParams()['id'] ?? 0),
            'actions' => [
                new Action(
                    'edit',
                    [
                        'idField' => 'uid',
                        'tableName' => 'tx_surfey_definition',
                        'returnUrl' => $requestUri,
                    ],
                    'actions-open',
                    'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:cm.edit'
                ),
                new Action(
                    'delete',
                    [
                        'idField' => 'uid',
                        'tableName' => 'tx_surfey_definition',
                        'title' => $languageService->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:labels.delete.title'),
                        'content' => $languageService->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:labels.delete.message'),
                        'ok' => $languageService->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:cm.delete'),
                        'cancel' => $languageService->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.cancel'),
                        'returnUrl' => $requestUri,
                    ],
                    'actions-edit-delete',
                    'LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:cm.delete'
                ),
                new Action(
                    'generatePrivateLink',
                    [
                        'idField' => 'uid',
                        'extensionName' => 'Surfey',
                    ],
                    'actions-link',
                    'LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:actions.generatePrivateLink'
                ),
            ],
        ])->renderResponse('Management/Overview');
    }

    protected function registerDocHeaderButtons(ModuleTemplate $view, ServerRequestInterface $request, SurfeyDefinitionDemand $demand): void
    {
        $languageService = $this->getLanguageService();
        $buttonBar = $view->getDocHeaderComponent()->getButtonBar();

        $requestUri = $request->getAttribute('normalizedParams')->getRequestUri();
        $newRecordButton = $buttonBar->makeLinkButton()
            ->setHref((string)$this->uriBuilder->buildUriFromRoute(
                'record_edit',
                [
                    'edit' => ['tx_surfey_definition' => [$request->getQueryParams()['id'] ?? 0 => 'new']],
                    'returnUrl' => $requestUri,
                ]
            ))
            ->setShowLabelText(true)
            ->setTitle($languageService->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:surfeydefinition.create'))
            ->setIcon($this->iconFactory->getIcon('actions-plus', IconSize::SMALL));
        $buttonBar->addButton($newRecordButton, ButtonBar::BUTTON_POSITION_LEFT, 10);

        $reloadButton = $buttonBar->makeLinkButton()
            ->setHref($requestUri)
            ->setTitle($languageService->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:labels.reload'))
            ->setIcon($this->iconFactory->getIcon('actions-refresh', IconSize::SMALL));
        $buttonBar->addButton($reloadButton, ButtonBar::BUTTON_POSITION_RIGHT);

        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setRouteIdentifier('web_surfey')
            ->setDisplayName($languageService->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:mlang_labels_tablabel'))
            ->setArguments(array_filter([
                'demand' => $demand->getParameters(),
                'orderField' => $demand->getOrderField(),
                'orderDirection' => $demand->getOrderDirection(),
            ]));
        $buttonBar->addButton($shortcutButton, ButtonBar::BUTTON_POSITION_RIGHT);
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}

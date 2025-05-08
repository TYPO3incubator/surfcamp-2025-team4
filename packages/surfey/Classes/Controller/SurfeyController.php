<?php

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Domain\RecordFactory;
use TYPO3\CMS\Core\Domain\RecordInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

#[Autoconfigure(public: true)]
final readonly class SurfeyController
{
    public function __construct(
        private ViewFactoryInterface $viewFactory,
        private RecordFactory $recordFactory,
    ) {}
    /**
     * Renders the surfey content element
     *
     * @param string $content The content
     * @param array $conf The TypoScript configuration
     * @return string The rendered content
     */
    public function render($content, $conf, ServerRequestInterface $request): string
    {
        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: ['EXT:surfey/Resources/Private/Frontend/Templates/'],
            partialRootPaths: ['EXT:surfey/Resources/Private/Frontend/Partials'],
            layoutRootPaths: ['EXT:surfey/Resources/Private/Frontend/Layouts'],
            templatePathAndFilename: 'EXT:surfey/Resources/Private/Frontend/Templates/Surfey.html',
            request: $request,
        );

        $currentContentObject = $request->getAttribute('currentContentObject');

        $record = $this->recordFactory->createResolvedRecordFromDatabaseRow('tt_content', $currentContentObject->data);

        $definition = $record->get('tx_surfey_definition')->get('definition');

        $view = $this->viewFactory->create($viewFactoryData);
        $view->getRenderingContext()->setAttribute(ServerRequestInterface::class, $request);

        $view->assign('record', $record);
        $view->assign('form', $definition);

        return $view->render();
    }
}

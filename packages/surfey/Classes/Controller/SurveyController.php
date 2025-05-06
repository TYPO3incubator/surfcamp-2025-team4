<?php

namespace TYPO3Incubator\Surfey\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

#[Autoconfigure(public: true)]
class SurveyController
{
    public function __construct(
        private ViewFactoryInterface $viewFactory,
    ) {}
    /**
     * Renders the survey content element
     *
     * @param string $content The content
     * @param array $conf The TypoScript configuration
     * @return string The rendered content
     */
    public function render($content, $conf, ServerRequestInterface $request): string
    {
        $viewFactoryData = new ViewFactoryData(
            templatePathAndFilename: 'EXT:surfey/Resources/Private/Templates/Survey.html',
            request: $request,
        );

        $view = $this->viewFactory->create($viewFactoryData);

        /** @var ContentObjectRenderer $currentContentObject */
        $currentContentObject = $request->getAttribute('currentContentObject');

        $view->assign('data', $currentContentObject->data);

        $view->getRenderingContext()->setAttribute(ServerRequestInterface::class, $request);

        return $view->render();
    }
}

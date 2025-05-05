<?php
namespace TYPO3Incubator\Surfey\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class SurveyController
{
    /**
     * Renders the survey content element
     *
     * @param string $content The content
     * @param array $conf The TypoScript configuration
     * @return string The rendered content
     */
    public function render($content, $conf): string
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);

        $view->setTemplateRootPaths([0 => 'EXT:surfey/Resources/Private/Templates/']);
        $view->setPartialRootPaths([0 => 'EXT:surfey/Resources/Private/Partials/']);
        $view->setLayoutRootPaths([0 => 'EXT:surfey/Resources/Private/Layouts/']);

        $view->setTemplate('Survey');

        $data = $GLOBALS['TSFE']->cObj->data;

        $view->assign('data', $data);

        return $view->render();
    }
}

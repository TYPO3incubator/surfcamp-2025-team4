<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3Incubator\Surfey\Form;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\StringUtility;

#[Autoconfigure(public: true)]
final class SurfeyEditorElement extends AbstractFormElement
{
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    protected $defaultFieldWizard = [
        'localizationStateSelector' => [
            'renderType' => 'localizationStateSelector',
        ],
        'otherLanguageContent' => [
            'renderType' => 'otherLanguageContent',
            'after' => [
                'localizationStateSelector',
            ],
        ],
        'defaultLanguageDifferences' => [
            'renderType' => 'defaultLanguageDifferences',
            'after' => [
                'otherLanguageContent',
            ],
        ],
    ];

    public function render(): array
    {
        $fieldName = $this->data['fieldName'];
        $parameterArray = $this->data['parameterArray'];
        $resultArray = $this->initializeResultArray();
        $fieldId = StringUtility::getUniqueId('tceforms-surfey-');
        $renderedLabel = $this->renderLabel($fieldId);
        $readOnly = (bool)($config['readOnly'] ?? false);

        $itemValue = $parameterArray['itemFormElValue'];
        if (!empty($parameterArray['itemFormElValue'])) {
            try {
                $itemValue = (string)json_encode($parameterArray['itemFormElValue'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
            }
        } else {
            $itemValue = '';
        }


        if ($readOnly) {
            $fieldInformationResult = $this->renderFieldInformation();
            $fieldInformationHtml = $fieldInformationResult['html'];
            $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldInformationResult, false);
            $html = [];
            $html[] = $$renderedLabel;
            $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
            $html[] =   $fieldInformationHtml;
            $html[] =   '<div class="form-wizards-wrap">';
            $html[] =       '<div class="form-wizards-item-element">';
            $html[] =           '<div class="form-control-wrap">';
            $html[] =               '<textarea class="form-control font-monospace" id="' . htmlspecialchars($fieldId) . '" rows="5" disabled>';
            $html[] =                   htmlspecialchars($itemValue);
            $html[] =               '</textarea>';
            $html[] =           '</div>';
            $html[] =       '</div>';
            $html[] =   '</div>';
            $html[] = '</div>';
            $resultArray['html'] = implode(LF, $html);
            return $resultArray;
        }

        $html = [];
        $html[] = '<button class="btn btn-default" type="button">';
        $html[] =     htmlspecialchars($this->getLanguageService()->sL('LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:element.surfeyEditor.button.label'));;;
        $html[] = '</button>';
        $html[] = '<input type="hidden" name="' . htmlspecialchars($fieldName) . '" value="' . htmlspecialchars($itemValue) . '" id="' . htmlspecialchars($fieldId) . '">';

        $resultArray['html'] =
            '<typo3-formengine-element-surfey class="formengine-field-item t3js-formengine-field-item" recordFieldId="' . htmlspecialchars($fieldId) . '">
                ' . implode(LF, $html) . '
            </typo3-formengine-element-surfey>';

        $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create('@typo3incubator/surfey/surfey-element.js');

        return $resultArray;
    }
}

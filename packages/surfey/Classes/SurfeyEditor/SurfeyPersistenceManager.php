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

namespace TYPO3Incubator\Surfey\SurfeyEditor;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;
use TYPO3Incubator\Surfey\Domain\Repository\SurfeyDefinitionRepository;

class SurfeyPersistenceManager implements FormPersistenceManagerInterface
{
    public function __construct(private readonly SurfeyDefinitionRepository $repository)
    {

    }

    public function load(string $persistenceIdentifier, array $formSettings, array $typoScriptSettings): array
    {
        $definition = json_decode($this->repository->findById(
            $this->getUidFromPersistenceIdentifier($persistenceIdentifier))['definition'],
            true
        );

       if ($definition === []) {
           // Default survey
           return [
               'type' => 'Form',
               'identifier' => $persistenceIdentifier,
               'label' => 'Surfey',
               'prototypeName' => 'standard',
               'renderables' => [
                   [
                       'type' => 'Page',
                       'identifier' => 'page-1',
                       'label' => 'Step',

                   ]
               ]
           ];
       }

        return $definition;
    }

    public function save(string $persistenceIdentifier, array $formDefinition, array $formSettings): void
    {
        $this->repository->updateDefinition((int)str_replace('tx_surfey_definition.', '', $persistenceIdentifier), $formDefinition);
    }

    public function delete(string $persistenceIdentifier, array $formSettings): void
    {
        $this->repository->updateDefinition((int)str_replace('tx_surfey_definition.', '', $persistenceIdentifier), []);
    }

    public function listForms(array $formSettings): array
    {
        return [];
    }

    public function hasForms(array $formSettings): bool
    {
        return true;
    }

    public function getAccessibleFormStorageFolders(array $formSettings): array
    {
        return [];
    }

    public function getAccessibleExtensionFolders(array $formSettings): array
    {
        return [];
    }

    public function getUniquePersistenceIdentifier(string $formIdentifier, string $savePath, array $formSettings): string
    {
        return '';
    }

    public function getUniqueIdentifier(array $formSettings, string $identifier): string
    {
        return '';
    }

    public function isAllowedPersistencePath(string $persistencePath, array $formSettings): bool
    {
        return true;
    }

    public function hasValidFileExtension(string $fileName): bool
    {
        return true;
    }

    private function getUidFromPersistenceIdentifier(string $persistenceIdentifier): int
    {
        return (int)str_replace('tx_surfey_definition.', '', $persistenceIdentifier);
    }
}

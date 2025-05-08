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

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManager;
use TYPO3\CMS\Form\Mvc\Persistence\FormPersistenceManagerInterface;

#[AsAlias(FormPersistenceManagerInterface::class, public: true)]
class FormPersistenceManagerDelegator implements FormPersistenceManagerInterface
{
    private FormPersistenceManagerInterface $concretePersistenceManager;

    public function __construct(
        private readonly FormPersistenceManager $formPersistenceManager,
        private readonly SurfeyPersistenceManager $surfeyPersistenceManager
    ) {
        $this->concretePersistenceManager = $this->resolveManager();
    }

    public function load(string $persistenceIdentifier, array $formSettings, array $typoScriptSettings): array
    {
        return $this->concretePersistenceManager->load($persistenceIdentifier, $formSettings, $typoScriptSettings);
    }

    public function save(string $persistenceIdentifier, array $formDefinition, array $formSettings): void
    {
        $this->concretePersistenceManager->save($persistenceIdentifier, $formDefinition, $formSettings);
    }

    public function delete(string $persistenceIdentifier, array $formSettings): void
    {
        $this->concretePersistenceManager->delete($persistenceIdentifier, $formSettings);
    }

    public function listForms(array $formSettings): array
    {
        return $this->concretePersistenceManager->listForms($formSettings);
    }

    public function hasForms(array $formSettings): bool
    {
        return $this->concretePersistenceManager->hasForms($formSettings);
    }

    public function getAccessibleFormStorageFolders(array $formSettings): array
    {
        return $this->concretePersistenceManager->getAccessibleFormStorageFolders($formSettings);
    }

    public function getAccessibleExtensionFolders(array $formSettings): array
    {
        return $this->concretePersistenceManager->getAccessibleExtensionFolders($formSettings);
    }

    public function getUniquePersistenceIdentifier(string $formIdentifier, string $savePath, array $formSettings): string
    {
        return $this->concretePersistenceManager->getUniquePersistenceIdentifier($formIdentifier, $savePath, $formSettings);
    }

    public function getUniqueIdentifier(array $formSettings, string $identifier): string
    {
        return $this->concretePersistenceManager->getUniqueIdentifier($formSettings, $identifier);
    }

    public function isAllowedPersistencePath(string $persistencePath, array $formSettings): bool
    {
        return $this->concretePersistenceManager->isAllowedPersistencePath($persistencePath, $formSettings);
    }

    public function hasValidFileExtension(string $fileName): bool
    {
        return $this->concretePersistenceManager->hasValidFileExtension($fileName);
    }

    private function resolveManager(): FormPersistenceManagerInterface
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;

        if (($request instanceof ServerRequestInterface)
            && str_starts_with($request->getParsedBody()['formPersistenceIdentifier'] ?? $request->getQueryParams()['formPersistenceIdentifier'] ?? '', 'tx_surfey_definition')
        ) {
            return $this->surfeyPersistenceManager;
        }

        return $this->formPersistenceManager;
    }
}

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

namespace TYPO3Incubator\Surfey\Factory;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\DataHandling\RelationResolver;
use TYPO3\CMS\Core\Domain\Event\RecordCreationEvent;
use TYPO3\CMS\Core\Domain\Persistence\RecordIdentityMap;
use TYPO3\CMS\Core\Domain\RecordFactory;
use TYPO3\CMS\Core\Domain\RecordPropertyClosure;
use TYPO3\CMS\Core\Schema\TcaSchemaFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinition;

final class SurfeyEntityFactory
{
    public function __construct(
        private readonly TcaSchemaFactory $tcaSchemaFactory,
        private readonly RecordFactory $recordFactory,
        private readonly RelationResolver $relationResolver,
    ) {
    }

    #[AsEventListener]
    public function __invoke(RecordCreationEvent $event): void
    {
        switch ($event->getRawRecord()->getMainType()) {
            case 'tx_surfey_participation':
            case 'tx_surfey_submission':
                $event->setProperty('surfey', $this->transformSurfeyDefinition($event));
                break;
        }
    }

    private function transformSurfeyDefinition(RecordCreationEvent $event): RecordPropertyClosure
    {
        $schema = $this->tcaSchemaFactory->get($event->getRawRecord()->getMainType());
        $recordFactory = $this->recordFactory;
        $fieldInformation = $schema->getField('surfey');
        $rawRecord = $event->getRawRecord();
        $context = $event->getContext();
        $recordIdentityMap = GeneralUtility::makeInstance(RecordIdentityMap::class);
        return new RecordPropertyClosure(
            function () use ($rawRecord, $fieldInformation, $context, $recordFactory, $recordIdentityMap): ?SurfeyDefinition {
                $recordData = $this->relationResolver->resolve($rawRecord, $fieldInformation, $context)[0] ?? null;
                if ($recordData === null) {
                    return null;
                }
                $dbTable = $recordData['table'];
                $row = $recordData['row'];
                return new SurfeyDefinition($recordFactory->createResolvedRecordFromDatabaseRow($dbTable, $row, $context, $recordIdentityMap));
            }
        );
    }
}


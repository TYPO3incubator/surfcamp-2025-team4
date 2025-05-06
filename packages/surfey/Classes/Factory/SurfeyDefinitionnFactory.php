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

use TYPO3\CMS\Core\Domain\RecordFactory;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinition;

final readonly class SurfeyDefinitionnFactory
{
    public function __construct(
        private RecordFactory $recordFactory
    ){
    }

    public function createFromRow(array $row): SurfeyDefinition
    {
        $resolvedRecord = $this->recordFactory->createResolvedRecordFromDatabaseRow('tx_surfey_definition', $row);

        return new SurfeyDefinition(
            $resolvedRecord->get('title'),
            [], // @todo fix this
            (bool)$resolvedRecord->get('random_order'),
            (bool)$resolvedRecord->get('private_surfey'),
            (bool)$resolvedRecord->get('single_submission'),
            (bool)$resolvedRecord->get('notifications'),
        );
    }
}

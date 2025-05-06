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

namespace TYPO3Incubator\Surfey\Domain\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Incubator\Surfey\Domain\Model\SurfeySubmission;
use TYPO3Incubator\Surfey\Factory\SurfeySubmissionFactory;

readonly class SurfeySubmissionRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
        private SurfeySubmissionFactory $surfeySubmissionFactory,
    ) {
    }

    public function findAll(): array
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        return $this->map($queryBuilder->executeQuery()->fetchAllAssociative());
    }

    protected function map(array $rows): array
    {
        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->mapSingleRow($row);
        }
        return $items;
    }

    protected function mapSingleRow(array $row): SurfeySubmission
    {
        return $this->surfeySubmissionFactory->createFromRow(
            BackendUtility::convertDatabaseRowValuesToPhp('tx_surfey_submission', $row)
        );
    }

    private function getPreparedQueryBuilder(bool $removeVisibilityRestrictions = false): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_surfey_submission');
        if ($removeVisibilityRestrictions) {
            $queryBuilder->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        }
        $queryBuilder = $queryBuilder->select('*')->from('tx_surfey_submission');
        return $queryBuilder;
    }
}

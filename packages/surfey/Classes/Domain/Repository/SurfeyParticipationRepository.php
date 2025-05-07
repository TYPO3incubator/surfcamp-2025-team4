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
use Symfony\Component\Uid\Uuid;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyParticipation;
use TYPO3Incubator\Surfey\Factory\SurfeyParticipationFactory;

readonly class SurfeyParticipationRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
        private SurfeyParticipationFactory $surfeyParticipationFactory,
    ) {
    }

    public function createParticipation(int $surfeyId, int $feUserId = 0): int
    {
        $connection = $this->connectionPool->getConnectionForTable('tx_surfey_participation');
        $connection->insert(
            'tx_surfey_participation',
            array_filter([
                'surfey' => $surfeyId,
                'identifier' => Uuid::v4(),
                'fe_user' => $feUserId,
            ])
        );

        return (int)$connection->lastInsertId();
    }

    public function findAll(bool $onlyActive = false): array
    {
        $queryBuilder = $this->getPreparedQueryBuilder($onlyActive);
        return $this->map($queryBuilder->executeQuery()->fetchAllAssociative());
    }

    public function findBySurfey(int $surfeyId, bool $onlyActive = false): array
    {
        $queryBuilder = $this->getPreparedQueryBuilder($onlyActive);
        $queryBuilder->where($queryBuilder->expr()->eq('surfey', $queryBuilder->createNamedParameter($surfeyId, Connection::PARAM_INT)));
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

    protected function mapSingleRow(array $row): SurfeyParticipation
    {
        return $this->surfeyParticipationFactory->createFromRow(
            BackendUtility::convertDatabaseRowValuesToPhp('tx_surfey_participation', $row)
        );
    }

    private function getPreparedQueryBuilder(bool $onlyActive = false): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_surfey_participation');
        if ($onlyActive) {
            $queryBuilder->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        }
        return $queryBuilder->select('*')->from('tx_surfey_participation');
    }
}

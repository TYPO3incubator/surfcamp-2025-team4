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
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinition;
use TYPO3Incubator\Surfey\Domain\Model\SurfeyDefinitionDemand;
use TYPO3Incubator\Surfey\Factory\SurfeyDefinitionFactory;

readonly class SurfeyDefinitionRepository
{

    public function __construct(
        private ConnectionPool          $connectionPool,
        private SurfeyDefinitionFactory $surfeyDefinitionFactory,
    ) {
    }

    public function findAll(): array
    {
        $queryBuilder = $this->getPreparedQueryBuilder();
        return $this->map($queryBuilder->executeQuery()->fetchAllAssociative());
    }

    public function countAll(?int $pid = null): int
    {
        $qb = $this->getPreparedQueryBuilder();
        if ($pid !== null) {
            $qb->where($qb->expr()->eq('pid', $qb->createNamedParameter($pid, Connection::PARAM_INT)));
        }

        return (int)$qb->count('*')->executeQuery()->fetchOne();
    }

    /**
     * @return SurfeyDefinition[]
     */
    public function findByDemand(SurfeyDefinitionDemand $demand): array
    {
        return $this->map($this->getQueryBuilderForDemand($demand)
            ->setMaxResults($demand->getLimit())
            ->setFirstResult($demand->getOffset())
            ->executeQuery()
            ->fetchAllAssociative());
    }

    protected function getQueryBuilderForDemand(SurfeyDefinitionDemand $demand): QueryBuilder
    {
        $queryBuilder = $this->getPreparedQueryBuilder(true);
        $queryBuilder->orderBy(
            $demand->getOrderField(),
            $demand->getOrderDirection()
        );
        // Ensure deterministic ordering.
        if ($demand->getOrderField() !== 'uid') {
            $queryBuilder->addOrderBy('uid', 'asc');
        }

        $constraints = [];
        if ($demand->hasTitle()) {
            $escapedLikeString = '%' . $queryBuilder->escapeLikeWildcards($demand->getTitle()) . '%';
            $constraints[] = $queryBuilder->expr()->like(
                'title',
                $queryBuilder->createNamedParameter($escapedLikeString)
            );
        }
        if ($demand->hasPrivateSurfey()) {
            $constraints[] = $queryBuilder->expr()->eq(
                'private_surfey',
                $queryBuilder->createNamedParameter($demand->isPrivateSurfey(), Connection::PARAM_BOOL)
            );
        }
        if ($demand->hasPid()) {
            $constraints[] = $queryBuilder->expr()->eq(
                'pid',
                $queryBuilder->createNamedParameter($demand->getPid(), Connection::PARAM_INT)
            );
        }


        if (!empty($constraints)) {
            $queryBuilder->where(...$constraints);
        }
        return $queryBuilder;
    }

    protected function map(array $rows): array
    {
        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->mapSingleRow($row);
        }
        return $items;
    }

    protected function mapSingleRow(array $row): SurfeyDefinition
    {
        return $this->surfeyDefinitionFactory->createFromRow(
            BackendUtility::convertDatabaseRowValuesToPhp('tx_surfey_definition', $row)
        );
    }

    private function getPreparedQueryBuilder(bool $removeVisibilityRestrictions = false): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_surfey_definition');
        if ($removeVisibilityRestrictions) {
            $queryBuilder->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        }
        $queryBuilder = $queryBuilder->select('*')->from('tx_surfey_definition');
        return $queryBuilder;
    }
}

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

namespace TYPO3Incubator\Surfey\Domain\Model;

use Psr\Http\Message\ServerRequestInterface;

class SurfeyDefinitionDemand
{
    protected const ORDER_DESCENDING = 'desc';
    protected const ORDER_ASCENDING = 'asc';
    protected const DEFAULT_ORDER_FIELD = 'title';
    protected const ORDER_FIELDS = ['title', 'private_surfey'];

    protected int $limit = 15;

    public function __construct(
        protected int $page = 1,
        protected string $orderField = self::DEFAULT_ORDER_FIELD,
        protected string $orderDirection = self::ORDER_ASCENDING,
        protected string $title = '',
        protected ?bool $privateSurfey = null
    ) {
        if (!in_array($orderField, self::ORDER_FIELDS, true)) {
            $orderField = self::DEFAULT_ORDER_FIELD;
        }
        $this->orderField = $orderField;
        if (!in_array($orderDirection, [self::ORDER_DESCENDING, self::ORDER_ASCENDING], true)) {
            $orderDirection = self::ORDER_ASCENDING;
        }
        $this->orderDirection = $orderDirection;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $page = (int)($request->getQueryParams()['page'] ?? $request->getParsedBody()['page'] ?? 1);
        $orderField = (string)($request->getQueryParams()['orderField'] ?? $request->getParsedBody()['orderField'] ?? self::DEFAULT_ORDER_FIELD);
        $orderDirection = (string)($request->getQueryParams()['orderDirection'] ?? $request->getParsedBody()['orderDirection'] ?? self::ORDER_ASCENDING);
        $demand = $request->getQueryParams()['demand'] ?? $request->getParsedBody()['demand'] ?? [];
        if (!is_array($demand) || $demand === []) {
            return new self($page, $orderField, $orderDirection);
        }
        $title = (string)($demand['title'] ?? '');
        $privateSurfey = isset($demand['private_surfey']) ? (bool)$demand['private_surfey'] : null;
        return new self($page, $orderField, $orderDirection, $title, $privateSurfey);
    }

    public function getOrderField(): string
    {
        return $this->orderField;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function getDefaultOrderDirection(): string
    {
        return self::ORDER_ASCENDING;
    }

    public function getReverseOrderDirection(): string
    {
        return $this->orderDirection === self::ORDER_ASCENDING ? self::ORDER_DESCENDING : self::ORDER_ASCENDING;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function hasTitle(): bool
    {
        return $this->title !== '';
    }

    public function isPrivateSurfey(): bool
    {
        return $this->privateSurfey;
    }

    public function hasPrivateSurfey(): bool
    {
        return $this->privateSurfey !== null;
    }

    public function hasConstraints(): bool
    {
        return $this->hasTitle()
            || $this->hasPrivateSurfey();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    public function getParameters(): array
    {
        $parameters = [];
        if ($this->hasTitle()) {
            $parameters['title'] = $this->getTitle();
        }
        if ($this->hasPrivateSurfey()) {
            $parameters['private_surfey'] = $this->isPrivateSurfey();
        }
        return $parameters;
    }
}

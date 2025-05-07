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

use TYPO3\CMS\Core\Domain\RawRecord;
use TYPO3\CMS\Core\Domain\Record\ComputedProperties;
use TYPO3\CMS\Core\Domain\RecordInterface;

trait SurfeyEntityTrait
{
    public RecordInterface $record;

    public function get(string $id)
    {
        return $this->record->get($id);
    }

    public function has(string $id): bool
    {
        return $this->record->has($id);
    }

    public function getUid(): int
    {
        return $this->record->getUid();
    }

    public function getPid(): int
    {
        return $this->record->getPid();
    }

    public function getFullType(): string
    {
        return $this->record->getFullType();
    }

    public function getRecordType(): ?string
    {
        return $this->record->getRecordType();
    }

    public function getMainType(): string
    {
        return $this->record->getMainType();
    }

    public function toArray(): array
    {
        return $this->record->toArray();
    }

    public function getRawRecord(): ?RawRecord
    {
        return $this->record->getRawRecord();
    }

    public function getComputedProperties(): ComputedProperties
    {
        return $this->record->getComputedProperties();
    }
}

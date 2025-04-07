<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

final class ConjuredUpdatableItem extends UpdatableItem 
{
    private const MINIMUM_QUALITY = 0;

    protected function updateQuality(): void
    {
        if ($this->quality <= self::MINIMUM_QUALITY) {
            return;
        }

        $this->quality = $this->quality - 2;
    }
}

<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

final class AgedBrieUpdatableItem extends UpdatableItem 
{
    private const MAXIMUM_ITEM_QUALITY = 50;

    protected function updateQuality(): void
    {
        if ($this->quality >= self::MAXIMUM_ITEM_QUALITY) {
            return;
        }

        $this->quality = $this->quality + 1;
    }
}

<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

final class ConjuredUpdatableItem extends UpdatableItem 
{
    protected function updateQuality(): void
    {
        if ($this->quality <= 0) {
            return;
        }

        $this->quality = $this->quality - 2;
    }
}

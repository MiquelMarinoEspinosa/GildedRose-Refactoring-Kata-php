<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\UpdatableItem\UpdatableItem;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $updatableItem = UpdatableItem::create(
                $item->name,
                $item->sellIn,
                $item->quality
            );
            $updatableItem = $updatableItem->update();

            $item->quality = $updatableItem->quality;
            $item->sellIn = $updatableItem->sellIn;
        }
    }
}

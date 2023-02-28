<?php

declare(strict_types=1);

namespace GildedRose;

class BackstagePassesGildedRoseItem extends AbstractGildedRoseItem
{

    public function increaseQuality(): void
    {
        if ($this->sellIn <= 10) {
            $this->quality += 1;
        }

        if ($this->sellIn <= 5) {
            $this->quality += 1;
        }

        $this->quality += 1;
    }

    public function decreaseQuality(): void
    {
        $this->quality = 0;
    }

    public function decreaseSellInDate(): void
    {
        $this->sellIn -= 1;
    }
}

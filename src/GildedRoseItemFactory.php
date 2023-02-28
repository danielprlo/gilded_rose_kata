<?php

declare(strict_types=1);

namespace GildedRose;

class GildedRoseItemFactory
{
    public static function create(Item $item): InterfaceGildedRoseItem
    {
        if ($item->name === 'Aged Brie') {
            return new AgingGildedRoseItem($item->name, $item->sellIn, $item->quality);
        }

        if (str_contains($item->name, 'Backstage passes')) {
            return new BackstagePassesGildedRoseItem($item->name, $item->sellIn, $item->quality);
        }

        if ($item->name === 'Sulfuras, Hand of Ragnaros') {
            return new LegendaryGildedRoseItem($item->name, $item->sellIn, $item->quality);
        }

        if (str_contains($item->name, 'Conjured')) {
            return new ConjuredGildedRoseItem($item->name, $item->sellIn, $item->quality);
        }

        return new StandardGildedRoseItem($item->name, $item->sellIn, $item->quality);
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testAgingProductQualityIncreases(): void
    {
        $items = [
            new Item('Aged Brie', 20, 30),
            new Item('Backstage passes to a TAFKAL80ETC concert', 20, 30),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertSame(31, $items[0]->quality);
        $this->assertSame(31, $items[1]->quality);
    }

    public function testBackstagePassesQualityIncrease2When10DaysOrLess(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(32, $items[0]->quality);
    }

    public function testBackstagePassesQualityIncrease3When5DaysOrLess(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(33, $items[0]->quality);
    }

    public function testRegularProductQualityDecreases(): void
    {
        $items = [new Item('AnythingElse', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(29, $items[0]->quality);
    }

    public function testRegularProductQualityDecreasesFasterWhenExpired(): void
    {
        $items = [new Item('AnythingElse', 0, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(28, $items[0]->quality);
    }

    public function testLegendaryProductNeverLosesQuality(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 1, 80)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(80, $items[0]->quality);
    }

    public function testLegendaryProductNeverDecreasesSellIn(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 1, 80)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(1, $items[0]->sellIn);
    }

    public function testQualityOfProductIsNotNegative(): void
    {
        $items = [new Item('AnythingElse', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function testQualityOfProductNeverAbove50(): void
    {
        $items = [
            new Item('Aged Brie', 20, 50),
            new Item('Backstage passes to a TAFKAL80ETC concert', 20, 50),
        ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
        $this->assertSame(19, $items[0]->sellIn);
        $this->assertSame(50, $items[1]->quality);
        $this->assertSame(19, $items[1]->sellIn);
    }

    public function testConjuredProductQualityDecreasesTwiceAsFast(): void
    {
        $items = [new Item('Conjured sword', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(28, $items[0]->quality);
        $this->assertSame(9, $items[0]->sellIn);
    }
}

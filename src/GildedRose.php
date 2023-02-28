<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    public const QUALITY_DEFAULT_MAX = 50;

    public const QUALITY_MIN_ACCEPTABLE = 0;

    public const PASSED_SELLING_POINT_DATE = 0;

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
            $gildedRoseItem = GildedRoseItemFactory::create($item);

            $this->updateProductQuality($gildedRoseItem);

            $gildedRoseItem->decreaseSellInDate();

            if ($gildedRoseItem->getSellIn() < self::PASSED_SELLING_POINT_DATE) {
                $this->updateProductQualityPassedSellingPoint($gildedRoseItem);
            }

            /* So the goblin in the corner is happy I won't touch the array */
            $item->quality = $gildedRoseItem->getQuality();
            $item->sellIn = $gildedRoseItem->getSellIn();
        }
    }

    private function updateProductQualityPassedSellingPoint(InterfaceGildedRoseItem $gildedRoseItem): void
    {
        if (is_a($gildedRoseItem, AgingGildedRoseItem::class)) {
            if (! $this->isItemMaxQuality($gildedRoseItem->getQuality())) {
                $gildedRoseItem->increaseQuality();
            }
        } elseif (is_a($gildedRoseItem, BackstagePassesGildedRoseItem::class) ||
            is_a($gildedRoseItem, ConjuredGildedRoseItem::class)) {
            $gildedRoseItem->decreaseQuality();
        } else {
            if ($this->isItemQualityNotNegative($gildedRoseItem->getQuality())) {
                $gildedRoseItem->decreaseQuality();
            }
        }
    }

    private function updateProductQuality(InterfaceGildedRoseItem $gildedRoseItem): void
    {
        if (
            is_a($gildedRoseItem, StandardGildedRoseItem::class) ||
            is_a($gildedRoseItem, ConjuredGildedRoseItem::class)
        ) {
            if ($this->isItemQualityNotNegative($gildedRoseItem->getQuality())) {
                $gildedRoseItem->decreaseQuality();
            }
        } else {
            if (! $this->isItemMaxQuality($gildedRoseItem->getQuality())) {
                $gildedRoseItem->increaseQuality();
            }
        }
    }

    private function isItemMaxQuality(int $quality): bool
    {
        if ($quality >= self::QUALITY_DEFAULT_MAX) {
            return true;
        }

        return false;
    }

    private function isItemQualityNotNegative(int $quality): bool
    {
        if ($quality > self::QUALITY_MIN_ACCEPTABLE) {
            return true;
        }

        return false;
    }
}

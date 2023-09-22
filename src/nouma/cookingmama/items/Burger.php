<?php

namespace nouma\cookingmama\items;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\CustomiesItemFactory;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use nouma\cookingmama\Craftable;
use nouma\cookingmama\RecipeType;
use pocketmine\item\Food;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\VanillaItems;

class Burger extends Food implements ItemComponents, Craftable
{
    use ItemComponentsTrait;

    public function __construct(ItemIdentifier $identifier, string $name = "Unknown") {
        parent::__construct($identifier, $name);
        $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_EQUIPMENT);
        $this->initComponent("burger_beef", $creativeInfo);
    }

    public function getFoodRestore(): int
    {
        return 12;
    }

    public function getSaturationRestore(): float
    {
        return 10;
    }

    public function getIngredients(): array
    {
        return [VanillaItems::BREAD()->setCount(2), VanillaItems::STEAK()];
    }

    public function getResult(): Item
    {
        return CustomiesItemFactory::getInstance()->get('cristelia:burger_beef');
    }

    public function getRecipeType(): RecipeType
    {
        return RecipeType::OVEN;
    }
}
<?php

namespace nouma\cookingmama;

use pocketmine\item\Item;

interface Craftable
{
    public function getIngredients(): array;
    public function getResult(): Item;
    public function getRecipeType(): RecipeType;
}
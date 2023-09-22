<?php

namespace nouma\cookingmama;

use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\block\Material;
use customiesdevs\customies\block\Model;
use customiesdevs\customies\item\CustomiesItemFactory;
use nouma\cookingmama\blocks\Oven;
use nouma\cookingmama\items\Burger;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    private static Main $instance;

    private RecipeManager $recipeManager;

    protected function onEnable(): void
    {
        self::$instance = $this;

        $this->recipeManager = new RecipeManager($this);

        $material = new Material(Material::TARGET_ALL, "oven", Material::RENDER_METHOD_ALPHA_TEST);
        $model = new Model([$material], "geometry.oven", new Vector3(-8, 0, -8), new Vector3(16, 16, 16));
        CustomiesBlockFactory::getInstance()->registerBlock(static fn() => new Oven(), "cristelia:oven", $model);

        CustomiesItemFactory::getInstance()->registerItem(Burger::class, "cristelia:burger_beef", "Burger Beef");

        RecipeManager::getInstance()->registerRecipe(CustomiesItemFactory::getInstance()->get('cristelia:burger_beef'));
    }

    public static function getInstance(): Main {
        return Main::$instance;
    }
}
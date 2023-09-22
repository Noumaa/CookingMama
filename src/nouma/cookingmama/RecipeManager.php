<?php

namespace nouma\cookingmama;

class RecipeManager
{
    private static RecipeManager $instance;

    private Main $plugin;
    private array $recipes;

    public function __construct(Main $plugin, array $recipes = [])
    {
        self::$instance = $this;
        $this->plugin = $plugin;
        $this->recipes = $recipes;
    }

    public function registerRecipe(Craftable $item): void
    {
        if (!key_exists($item->getRecipeType(), $this->recipes))
            $this->recipes[$item->getRecipeType()] = [];
        $this->recipes[$item->getRecipeType()] += [$item];
        $this->plugin->getLogger()->info('Registered '.$item->getResult()->getName().'\'s recipe');
    }

    public function getRecipes(int $type = null): array
    {
        if ($type == null) return $this->recipes;
        return $this->recipes[$type];
    }

    public static function getInstance(): RecipeManager {
        return RecipeManager::$instance;
    }
}
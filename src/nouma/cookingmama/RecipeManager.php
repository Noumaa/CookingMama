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
        if (!key_exists($item->getRecipeType()->name, $this->recipes))
            $this->recipes[$item->getRecipeType()->name] = [];
        $this->recipes[$item->getRecipeType()->name] += [$item];
        $this->plugin->getLogger()->info('Registered '.$item->getResult()->getName().'\'s recipe');
    }

    public function getRecipes(RecipeType $type = null): array
    {
        if ($type == null) return $this->recipes;
        return $this->recipes[$type->name];
    }

    public static function getInstance(): RecipeManager {
        return RecipeManager::$instance;
    }
}
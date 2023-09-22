<?php

namespace nouma\cookingmama\blocks;

use customiesdevs\customies\item\CustomiesItemFactory;
use Jibix\Forms\form\type\MenuForm;
use Jibix\Forms\menu\Button;
use Jibix\Forms\menu\Image;
use Jibix\Forms\menu\type\CloseButton;
use nouma\cookingmama\RecipeManager;
use nouma\cookingmama\RecipeType;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\block\CraftingTable;
use pocketmine\item\Item;
use pocketmine\item\ToolTier;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Oven extends Block
{
    public function __construct()
    {
        parent::__construct(
            new BlockIdentifier(BlockTypeIds::newId()),
            "Oven",
            new BlockTypeInfo(BlockBreakInfo::pickaxe(1.0, ToolTier::STONE()))
        );
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
        if ($player != null) $this->openOven($player);
        return parent::onInteract($item, $face, $clickVector, $player, $returnedItems);
    }

    private function openOven(Player $player, string $content = '') {
        $onSubmit = function (Player $player, Button $selected) {
            switch ($selected->getValue()) {
                case 0:
                    foreach (RecipeManager::getInstance()->getRecipes(RecipeType::OVEN) as $recipe) {
                        $player->sendMessage($recipe->getResult());
                    }
                    if ($player->getInventory()->contains(VanillaItems::BREAD()->setCount(2)) && $player->getInventory()->contains(VanillaItems::STEAK())) {
                        $player->getInventory()->removeItem(VanillaItems::BREAD()->setCount(2));
                        $player->getInventory()->removeItem(VanillaItems::STEAK());
                        $player->getInventory()->addItem(CustomiesItemFactory::getInstance()->get('cristelia:burger_beef'));
                        return;
                    }
                    $this->openOven($player, '§cVous n\'avez pas les ingrédients requis !');
            }
        };

        $player->sendForm(new MenuForm('Recettes', $content, [
            new Button('§8Beef Burger §ex1 §8(Pain §ex2§8, §8Steak §ex1§8)', $onSubmit, Image::path('textures/items/burger_beef')),
            new CloseButton('§cFermer')
        ]));
    }
}
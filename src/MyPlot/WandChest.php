<?php

namespace MyPlot;

use MyPlot\MyPlot;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\InvMenu;

class WandChest
{

	private $plugin;

	public function __Construct(MyPlot $plugin)
	{

		$this->plugin = $plugin;

		if (!InvMenuHandler::isRegistered()) {
			InvMenuHandler::register($plugin);
		}
	}

	public function Wand(Player $player)
	{
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);

		$menu->readonly();
		$menu->setName(TF::GRAY . "➤ " . TF::GOLD . "Plot Wand");

		$slab1 = Item::get(44, 0, 1);
		$slab1->setCustomName(TF::RESET . TF::GOLD . "Stone Slab");

		$slab2 = Item::get(44, 2, 1);
		$slab2->setCustomName(TF::RESET . TF::GOLD . "Wooden Slab");

		$slab3 = Item::get(44, 3, 1);
		$slab3->setCustomName(TF::RESET . TF::GOLD . "Cobblestone Slab");

		$slab4 = Item::get(44, 5, 1);
		$slab4->setCustomName(TF::RESET . TF::GOLD . "Stone Brick Slab");

		$slab5 = Item::get(44, 6, 1);
		$slab5->setCustomName(TF::RESET . TF::GOLD . "Quartz Slab");

		$slab6 = Item::get(44, 7, 1);
		$slab6->setCustomName(TF::RESET . TF::GOLD . "Nether Brick Slab");

		$fence1 = Item::get(85, 0, 1);
		$fence1->setCustomName(TF::RESET . TF::GOLD . "Oak Fence");

		$fence2 = Item::get(85, 1, 1);
		$fence2->setCustomName(TF::RESET . TF::GOLD . "Spruce Fence");

		$fence3 = Item::get(85, 2, 1);
		$fence3->setCustomName(TF::RESET . TF::GOLD . "Birch Fence");

		$fence4 = Item::get(85, 3, 1);
		$fence4->setCustomName(TF::RESET . TF::GOLD . "Jungle Fence");

		$fence5 = Item::get(85, 4, 1);
		$fence5->setCustomName(TF::RESET . TF::GOLD . "Acacia Fence");

		$fence6 = Item::get(85, 5, 1);
		$fence6->setCustomName(TF::RESET . TF::GOLD . "Dark Oak Fence");

		$block1 = Item::get(42, 0, 1);
		$block1->setCustomName(TF::RESET . TF::GOLD . "Iron Block");

		$block2 = Item::get(41, 0, 1);
		$block2->setCustomName(TF::RESET . TF::GOLD . "Gold Block");

		$block3 = Item::get(57, 0, 1);
		$block3->setCustomName(TF::RESET . TF::GOLD . "Diamond Block");

		$block4 = Item::get(138, 0, 1);
		$block4->setCustomName(TF::RESET . TF::GOLD . "Beacon");

		$back = Item::get(44, 1, 1);
		$back->setCustomName(TF::RESET . TF::GOLD . "Zurücksetzen");
		$inv = $menu->getInventory();
		$inv->setItem(0, $slab1);
		$inv->setItem(1, $slab2);
		$inv->setItem(2, $slab3);
		$inv->setItem(3, $slab4);
		$inv->setItem(4, $slab5);
		$inv->setItem(5, $slab6);
		$inv->setItem(6, $fence1);
		$inv->setItem(7, $fence2);
		$inv->setItem(8, $fence3);
		$inv->setItem(9, $fence4);
		$inv->setItem(10, $fence5);
		$inv->setItem(11, $fence6);
		$inv->setItem(12, $block1);
		$inv->setItem(13, $block2);
		$inv->setItem(14, $block3);
		$inv->setItem(15, $block4);
		$inv->setItem(26, $back);

		$menu->setListener([$this, "onTransaction"]);
		$menu->setListener(function (player $player, item $itemClickedOn, Item $itemClickedwith): bool {

			$plot = $this->plugin->getPlotByPosition($player);

			if ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Stone Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");
				$this->plugin->newRandPlot($plot, 256, 44, 0);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Wooden Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 2);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Cobblestone Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 3);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Stone Brick Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 5);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Quartz Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 6);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Nether Brick Slab") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 7);

			}

			if ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Oak Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 85, 0);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Spruce Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 85, 1);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Birch Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 85, 2);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Jungle Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");
				$this->plugin->newRandPlot($plot, 256, 85, 3);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Acacia Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 85, 4);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Dark Oak Fence") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 85, 5);

			}

			if ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Iron Block") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 42, 0);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Gold Block") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 41, 0);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Diamond Block") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 57, 0);

			} elseif ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Beacon") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 138, 0);

			}

			if ($itemClickedOn->getCustomName() === TF::RESET . TF::GOLD . "Zurücksetzen") {
				$player->sendMessage("§6Plot§8»§e Der Rand deines Grundstück wurde geändert!");

				$this->plugin->newRandPlot($plot, 256, 44, 1);

			}
			return true;
		});
		$menu->send($player);
	}

	public function onTransaction(Player $player, Item $itemTakenOut, Item $itemPutIn, SlotChangeAction $inventoryAction): bool
	{
		$player->removeWindow($inventoryAction->getInventory());
		return true;
	}
}
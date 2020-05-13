<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class AddHelperSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender): bool
	{
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.addhelper");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args): bool
	{

		$prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

		if (empty($args)) {
			return false;
		}
		$helper = $args[0];
		$merge = new Config($this->getPlugin()->getDataFolder() . "merge_" . $sender->getLevel()->getName() . ".yml", 2);
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if ($plot === null) {
			$sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
			return true;
		}
		if ($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.addhelper")) {
			$sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
			return true;
		}
		$helper = $this->getPlugin()->getServer()->getPlayer($helper) ?? $this->getPlugin()->getServer()->getOfflinePlayer($helper);
			if ($merge->exists("$plot")) {
				$sender->sendMessage($prefix . TF::AQUA . $helper->getName() . TF::GRAY . " wurde zu einem Helfer von diesem Merge ernannt.");
				if ($this->getPlugin()->addPlotHelper($plot, $helper->getName())) {
				} else {
					$sender->sendMessage($prefix . TF::RED . "Fehler!");
				}
			} else {
				$sender->sendMessage($prefix . TF::AQUA . $helper->getName() . TF::GRAY . " wurde zu einem Helfer von diesem Grundstück ernannt.");
				if ($this->getPlugin()->addPlotHelper($plot, $helper->getName())) {
				} else {
					$sender->sendMessage($prefix . TF::RED . "Fehler!");
				}


			}
			return true;
	}
}

































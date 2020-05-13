<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class FillSubCommand extends SubCommand {

	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.pvp");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

		$prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
			$sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
			return true;
		}
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.fill")) {
			$sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
			return true;
		}
		$merge = new Config($this->getPlugin()->getDataFolder() . "merge.yml", 2);
		if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
			$sender->sendMessage($prefix . TF::GRAY . "§cDu kannst nicht den rand von einem Merge verändern!");
			return true;
		} else {

			$economy = $this->getPlugin()->getEconomyProvider();
			$plotLevel = $this->getPlugin()->getLevelSettings($plot->levelName);
			if (isset($args[0]) and $args[0] == "confirm") {
				if ($economy !== null and !$economy->reduceMoney($sender, $plotLevel->fillPrice)) {
					$sender->sendMessage(TF::RED . "Du besitzt zu wenig geld!");
					return true;
				} else {
					$this->getPlugin()->fillPlot($plot);
					$sender->sendMessage($prefix . "§aDu hast dein Grundstück erfolgreich ausgehüllt!");
					return true;
				}
			} else {
				$plotId = $plot;
				$sender->sendMessage($prefix . "Bist du sicher, dass du das Grundstück " . TF::GOLD . $plotId . TF::GRAY . " aushüllen möchtest für " . $plotLevel->fillPrice . "$ ?");
				$sender->sendMessage($prefix . "Wenn ja, benutze " . TF::GOLD . "/p fill confirm" . TF::GRAY . ".");
				return true;
			}
		}
	}
}
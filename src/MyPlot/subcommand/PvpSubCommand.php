<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class PvpSubCommand extends SubCommand {

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
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.pvp")) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
            return true;
		}
		$levelSettings = $this->getPlugin()->getLevelSettings($sender->level->getFolderName());
		if($levelSettings->restrictPVP) {
			$sender->sendMessage($prefix . TF::GRAY . "PvP ist in dieser Grundstückswelt deaktiviert.");
			return true;
		}
		if($this->getPlugin()->setPlotPvp($plot, !$plot->pvp)) {
			$sender->sendMessage($prefix . TF::GRAY . "PvP-Modus ist nun " . TF::GOLD . ($plot->pvp ? "deaktiviert" : "aktiviert") . TF::GRAY . " für das Grundstück.");
		}else {
			$sender->sendMessage($prefix . TF::RED . "Fehler!");
		}
		return true;
	}
}
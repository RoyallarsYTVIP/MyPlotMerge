<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class UnDenySubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.undenyplayer");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

        if(empty($args)) {
			return false;
		}
		$dplayer = $args[0];
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
            $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
			return true;
		}
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.undenyplayer")) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
			return true;
		}
		if(!$plot->unDenyPlayer($dplayer)) {
			$sender->sendMessage($prefix . TF::AQUA . $dplayer . TF::GRAY . " ist immer noch gesperrt.");
			return true;
		}
		$dplayer = $this->getPlugin()->getServer()->getPlayer($dplayer) ?? $this->getPlugin()->getServer()->getOfflinePlayer($dplayer);
		if($this->getPlugin()->removePlotDenied($plot, $dplayer->getName())) {
			$sender->sendMessage($prefix . TF::AQUA . $dplayer->getName() . TF::GRAY . " ist nun entsperrt.");
			if($dplayer instanceof Player) {
				$dplayer->sendMessage($prefix . TF::GRAY . "Du darfst das Grundstück" . TF::GOLD . " (" . $plot->X . ";" . $plot->Z . ") " . TF::GRAY . " von " . TF::AQUA . $sender->getName() . TF::GRAY . " nun wieder betreten.");
			}
		}else{
			$sender->sendMessage($prefix . TF::RED . "Fehler!");
		}
		return true;
	}
}
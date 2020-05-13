<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class MiddleSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and ($sender->hasPermission("myplot.command.middle"));
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

        if(count($args) != 0) {
			return false;
		}
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
            $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
            return true;
		}
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.middle")) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
            return true;
		}
		if($this->getPlugin()->teleportPlayerToPlot($sender, $plot, true)) {
			$sender->sendMessage($prefix . TF::GRAY . "Du wurdest in die Mitte des Grundstücks teleportiert.");
		}
		return true;
	}
}
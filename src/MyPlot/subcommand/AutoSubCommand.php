<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class AutoSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.auto");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

        $levelName = $sender->getLevel()->getFolderName();
		if(!$this->getPlugin()->isLevelLoaded($levelName)) {
			$sender->sendMessage($prefix . TF::RED . "Du bist nicht in einer Grundstückswelt.");
			return true;
		}
		if(($plot = $this->getPlugin()->getNextFreePlot($levelName)) !== null) {
			if($this->getPlugin()->teleportPlayerToPlot($sender, $plot, true)) {
				$sender->sendMessage($prefix . "Du wurdest erfolgreich zu dem Grundstück " . TF::GOLD . "(" . $plot->X . ";" . $plot->Z . ")" . TF::GRAY . " teleportiert.");
				$cmd = new ClaimSubCommand($this->getPlugin(), "claim");
				if(isset($args[0]) and strtolower($args[0]) == "true" and $cmd->canUse($sender)) {
					$cmd->execute($sender, [$args[1]]);
				}
			}else {
				$sender->sendMessage($prefix . TF::RED . "Fehler!");
			}
		}else{
			$sender->sendMessage($prefix . TF::GRAY . "Es wurde kein verfügbares Grundstück gefunden.");
		}
		return true;
	}
}
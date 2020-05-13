<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class ClaimSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.claim");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

        $name = "";
		if(isset($args[0])) {
			$name = $args[0];
		}
		$player = $sender->getServer()->getPlayer($sender->getName());
		$plot = $this->getPlugin()->getPlotByPosition($player);
		if($plot === null) {
            $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
            return true;
		}
		if($plot->owner != "") {
			if($plot->owner === $sender->getName()) {
				$sender->sendMessage($prefix . TF::GRAY . "Dir gehört dieses Grundstück bereits.");
			}else{
				$sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört bereits " . TF::AQUA . $plot->owner . TF::GRAY . ".");
			}
			return true;
		}
		$maxPlots = $this->getPlugin()->getMaxPlotsOfPlayer($player);
		$plotsOfPlayer = 0;
		foreach($this->getPlugin()->getPlotLevels() as $level => $settings) {
			$level = $this->getPlugin()->getServer()->getLevelByName((string)$level);
			if(!$level->isClosed()) {
				$plotsOfPlayer += count($this->getPlugin()->getPlotsOfPlayer($player->getName(), $level->getFolderName()));
			}
		}
		if($plotsOfPlayer >= $maxPlots) {
			$sender->sendMessage($prefix . TF::GRAY . "Du darfst das Limit von " . TF::GOLD . $maxPlots . TF::GRAY . " Grundstücken pro Spieler nicht überschreiten.");
			return true;
		}

		if($this->getPlugin()->claimPlot($plot, $sender->getName(), $name)) {
            $this->getPlugin()->newRandPlot($plot, 256, 44, 1);
            $sender->sendMessage($prefix . TF::GRAY . "Du hast dieses Grundstück erfolgreich für dich beansprucht.");
        }else{
			$sender->sendMessage($prefix . TF::RED . "Fehler!");
		}
		return true;
	}
}
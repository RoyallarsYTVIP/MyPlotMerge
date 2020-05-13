<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class GiveSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.give");
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
		$newOwner = $args[0];
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
            $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
            return true;
        }
		if($plot->owner !== $sender->getName()) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
            return true;
		}
		$newOwner = $this->getPlugin()->getServer()->getPlayer($newOwner);
		if(!$newOwner instanceof Player) {
			$sender->sendMessage($prefix . TF::GRAY . "Dieser Spieler ist nicht online.");
			return true;
		}elseif($newOwner->getName() === $sender->getName()) {
			$sender->sendMessage($prefix . TF::GRAY . "Du kannst dir dein Grundstück nicht selbst geben.");
			return true;
		}
		$maxPlots = $this->getPlugin()->getMaxPlotsOfPlayer($newOwner);
		$plotsOfPlayer = count($this->getPlugin()->getPlotsOfPlayer($newOwner->getName(), $newOwner->getLevel()->getFolderName()));
		if($plotsOfPlayer >= $maxPlots) {
			$sender->sendMessage($prefix . TF::GRAY . "Dieser Spieler hat die maximale Anzahl seiner Grundstücke erreicht.");
			return true;
		}
		if(count($args) == 2 and $args[1] == "confirm") {
			if($this->getPlugin()->claimPlot($plot, $newOwner->getName())) {
				$plotId = $plot;
				$oldOwnerName = $sender->getName();
				$newOwnerName = $newOwner->getName();
				$sender->sendMessage($prefix . TF::GRAY . "Du hast das Grundstück an " . TF::AQUA . $newOwnerName . TF::GRAY . " gegeben.");
				$newOwner->sendMessage($prefix . TF::AQUA . $oldOwnerName . TF::GRAY . " hat dir das Grundstück " . TF::GOLD . $plotId . TF::GRAY . " gegeben.");
			}else{
				$sender->sendMessage($prefix . TF::RED . "Fehler!");
			}
		}else{
			$plotId = $plot;
			$newOwnerName = $newOwner->getName();
			$sender->sendMessage($prefix . TF::GRAY . "Bist du sicher, dass du das Grundstück " . TF::GOLD . $plotId . TF::GRAY . " dem Spieler " . TF::AQUA . $newOwnerName . TF::GRAY . " geben möchtest?");
			$sender->sendMessage($prefix . TF::GRAY . "Wenn ja, benutze " . TF::GOLD . "/p give " . $newOwnerName . " confirm" . TF::GRAY . ".");
		}
		return true;
	}
}
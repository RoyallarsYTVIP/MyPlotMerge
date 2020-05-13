<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class DisposeSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.dispose");
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
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.dispose")) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
            return true;
		}
		if(isset($args[0]) and $args[0] == "confirm") {
			if($this->getPlugin()->disposePlot($plot)) {
                $this->getPlugin()->newRandPlot($plot, 256, 44, 4);
				$sender->sendMessage($prefix . TF::GRAY . "Das Grundstück wurde freigegeben.");
			}else{
				$sender->sendMessage($prefix . TF::RED . "Fehler!");
			}
		}else{
			$plotId = $plot;
            $sender->sendMessage($prefix . "Bist du sicher, dass du das Grundstück " . TF::GOLD . $plotId . TF::GRAY . " freigeben möchtest?");
            $sender->sendMessage($prefix . "Wenn ja, benutze " . TF::GOLD . "/p dispose confirm" . TF::GRAY . ".");
		}
		return true;
	}
}
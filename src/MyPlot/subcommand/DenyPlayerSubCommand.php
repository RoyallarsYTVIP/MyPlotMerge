<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class DenyPlayerSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.denyplayer");
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
		$dplayer = strtolower($args[0]);
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
            $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
            return true;
        }
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.denyplayer")) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
            return true;
        }
		$dplayer = $this->getPlugin()->getServer()->getPlayer($dplayer) ?? $this->getPlugin()->getServer()->getOfflinePlayer($dplayer);
		if(!$dplayer instanceof Player) {
            $sender->sendMessage($prefix . TF::GRAY . "Dieser Spieler ist momentan nicht online.");
            return true;
        }
        if($dplayer->hasPermission("myplot.admin.denyplayer.bypass") or $dplayer->getName() === $plot->owner) {
            $sender->sendMessage($prefix . TF::GRAY . "Du kannst " . TF::AQUA . $dplayer->getName() . TF::GRAY . " nicht verbieten, dein Grundstück zu betreten.");
			if($dplayer instanceof Player)
				$dplayer->sendMessage($prefix . TF::AQUA . $sender->getName() . TF::GRAY . " versucht, dich von einem Grundstück zu sperren.");
			return true;
		}
		if($this->getPlugin()->addPlotDenied($plot, $dplayer->getName())) {
			$sender->sendMessage($prefix . TF::AQUA . $dplayer->getName() . TF::GRAY . " darf dein Grundstück nun nicht mehr betreten.");
			if($dplayer instanceof Player) {
			    $dplayer->sendMessage($prefix . TF::GRAY . "Du darfst nicht mehr das Grundstück " . TF::GOLD . "(" . $plot->X . ";" . $plot->Z . ")" . TF::GRAY . " von " . TF::AQUA . $sender->getName() . TF::GRAY . " betreten.");
			}
		}else{
			$sender->sendMessage($prefix . TF::RED . "Fehler!");
		}
		return true;
	}
}
<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class KickSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender): bool
	{
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.kick");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */



		public function execute(CommandSender $sender, array $args) : bool {
			$prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;
		if (!isset($args[0])) {
			$sender->sendMessage("Syntax: /p kick <Name>");
			return true;
		}
		$plot = $this->getPlugin()->getPlotByPosition($sender);
		if($plot === null) {
			$sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
			return true;
		}
		if ($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.kick")) {
			$sender->sendMessage($prefix . TF::GRAY . "Dieses Grundstück gehört dir nicht.");
			return true;
		}
		$target = $this->getPlugin()->getServer()->getPlayer($args[0]);
		if ($target === null) {
			$sender->sendMessage($prefix . TF::GRAY . "Der Spieler §9" . $target . TF::GRAY . " wurde nicht gefunden!");
			return true;
		}
		if ($this->getPlugin()->getPlotByPosition($target)->isSame($plot)) {
			if ($target->hasPermission("myplot.admin.kick.bypass")) {
				$target->sendMessage($prefix . TF::BLUE . $sender->getName() . "§7 wollte dich von seinen Grundstück kicken");
				$sender->sendMessage($prefix . TF::GRAY . "§cDu kannst diesen Spieler nicht von dein Grundstück kicken!");
				return true;
			}
			if ($this->getPlugin()->teleportPlayerToPlot($target, $plot)) {
				$sender->sendMessage($prefix . TF::GRAY . "Du hast den Spieler erfolgreich gekickt");
				$target->sendMessage($prefix . TF::GRAY . "Du wurdest vom Grundstück gekickt");
				return true;
			} else {
				$sender->sendMessage("Error ;(");
			}
			return true;
		} else {
			$sender->sendMessage($prefix . TF::GRAY . "Der Spieler §9" . $target . TF::GRAY . " befindet sich nicht auf dein Grundstück!");
			return true;
		}
	}
	}


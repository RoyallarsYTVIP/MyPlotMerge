<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class WarpSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.warp");
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
		$levelName = $args[1] ?? $sender->getLevel()->getFolderName();
		if(!$this->getPlugin()->isLevelLoaded($levelName)) {
			$sender->sendMessage($prefix . TF::GRAY . "Du bist nicht in einer Grundstückswelt.");
			return true;
		}
		/** @var string[] $plotIdArray */
		$plotIdArray = explode(";", $args[0]);
		if(count($plotIdArray) != 2 or !is_numeric($plotIdArray[0]) or !is_numeric($plotIdArray[1])) {
            $sender->sendMessage($prefix . TF::GRAY . "Die Grundstück ID sollte in diesem Format sein: X;Z");
			return true;
		}
		$plot = $this->getPlugin()->getProvider()->getPlot($levelName, (int) $plotIdArray[0], (int) $plotIdArray[1]);
		if($plot->owner == "" and !$sender->hasPermission("myplot.admin.warp")) {
			$sender->sendMessage($prefix . TF::GRAY . "Du kannst dich nicht zu einem Grundstück teleportieren, das niemanden gehört.");
			return true;
		}
		if($this->getPlugin()->teleportPlayerToPlot($sender, $plot)) {
			$sender->sendMessage($prefix . TF::GRAY . "Du wurdest zu dem Grundstück " . TF::GOLD . $plot . TF::GRAY . " teleportiert.");
		}else{
			$sender->sendMessage($prefix . TF::GRAY . "Die Welt konnte nicht erstellt werden.");
		}
		return true;
	}
}
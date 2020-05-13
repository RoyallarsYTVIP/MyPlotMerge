<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use MyPlot\Plot;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\utils\TextFormat as TF;

class InfoSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender) : bool {
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.info");
	}

	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {

        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;

        if(isset($args[0])) {
			if(isset($args[1]) and is_numeric($args[1])) {
				$key = ((int) $args[1] - 1) < 1 ? 1 : ((int) $args[1] - 1);
				/** @var Plot[] $plots */
				$plots = [];
				foreach($this->getPlugin()->getPlotLevels() as $levelName => $settings) {
					$plots = array_merge($plots, $this->getPlugin()->getPlotsOfPlayer($args[0], $levelName));
				}
				if(isset($plots[$key])) {

					$plot = $plots[$key];
                    $sender->sendMessage($prefix . TF::GRAY . "Info - Plot " . TF::GOLD . $plot);
                    $sender->sendMessage(TF::GRAY . "Besitzer: " . TF::AQUA . $plot->owner);
                    $helpers = implode("§7, §b", $plot->helpers);
                    $sender->sendMessage(TF::GRAY ."Helfer: " . TF::AQUA . $helpers);
                    $denied = implode("§7, §b", $plot->denied);
                    $sender->sendMessage(TF::GRAY . "Gesperrt: " . TF::AQUA . $denied);

				}else{
					$sender->sendMessage($prefix . TF::GRAY . "Das Grundstück wurde nicht gefunden.");
				}
			}else{
				return false;
			}
		} else {
            $plot = $this->getPlugin()->getPlotByPosition($sender);
            if ($plot === null) {
                $sender->sendMessage($prefix . TF::GRAY . "Du befindest dich nicht auf einem Grundstück.");
                return true;
            }
            $sender->sendMessage($prefix . TF::GRAY . "Info - Plot " . TF::GOLD . $plot);
            $sender->sendMessage(TF::GRAY . "Besitzer: " . TF::AQUA . $plot->owner);
            $helpers = implode("§7, §b", $plot->helpers);
            $sender->sendMessage(TF::GRAY ."Helfer: " . TF::AQUA . $helpers);
            $denied = implode("§7, §b", $plot->denied);
            $sender->sendMessage(TF::GRAY . "Gesperrt: " . TF::AQUA . $denied);
			$merge = new Config($this->getPlugin()->getDataFolder() . "merge.yml", 2);
			if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
				$sender->sendMessage(TF::GRAY . "Merge: true");
			} else {
				$sender->sendMessage(TF::GRAY . "Merge: false");
			}

        }
		return true;
	}
}
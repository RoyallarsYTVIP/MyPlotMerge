<?php
declare(strict_types=1);
namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI;
use MyPlot\Commands;
use MyPlot\MyPlot;
use MyPlot\Plot;
use MyPlot\subcommand\SubCommand;
use pocketmine\level\Level;
use pocketmine\utils\TextFormat as TF;

class UnMergeSubCommand extends SubCommand
{
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	/**
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	public function canUse(CommandSender $sender): bool
	{
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.unmerge");
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
		$levelName = $sender->getLevel()->getFolderName();
		$merge = new Config($this->getPlugin()->getDataFolder() . "merge.yml", 2);
		if($plot === null) {
			$sender->sendMessage("§cDu befindest dich auf keinem Grundstück.");
			return true;
		}
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.unmerge")) {
			$sender->sendMessage("§cDas Grundstück gehört dir nicht!");
			return true;
		}


		if(empty($args[0])){
			switch($sender->getDirection()){
                case 0:
                    $direction = "east";
                    $sender->sendMessage("east");
                    break;
                case 1:

                    $direction = "south";
                    $sender->sendMessage("south");
                    break;
                case 2:
                    $direction = "west";
                    $sender->sendMessage("west");

                    break;
                case 3:
                    $direction = "north";
                    $sender->sendMessage("north");

                    break;
                default:
                    $sender->sendMessage("§r§cOops, da ist etwas falsch gelaufen beim erkennen deiner Blickrichtung.");
                    return false;
                    break;
			}
			if($direction == "north"){
				$da = $plot->X;
				$id = $plot->Z - 1;
				$plotN = $this->getPlugin()->getProvider()->getPlot($levelName, $da, $id);
				if($plotN->owner == $sender->getName() or $sender->hasPermission("myplot.admin.merge")) {
					if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
						$this->getPlugin()->unmergePlot($plot, $plotN, $sender, $direction);
						$sender->sendMessage("Deine Grundstücke wurden unmerged!");
					} else {
						$sender->sendMessage("§cDas Plot ist nicht gemerged");
					}
				}else {
					$sender->sendMessage("§cDu musst der Besitzer des Grundstücks welches du mergen willst sein!");
				}
			}
			if($direction == "west"){
				$id = $plot->Z;
				$plotN = $this->getPlugin()->getProvider()->getPlot($levelName, $plot->X - 1, $id);
				if($plotN->owner == $sender->getName() or $sender->hasPermission("myplot.admin.merge")) {
					if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
						$this->getPlugin()->unmergePlot($plot, $plotN, $sender, $direction);
						$sender->sendMessage("Deine Grundstücke wurden unmerged!");
					} else {
						$sender->sendMessage("§cDas Plot ist nicht gemerged");
					}
				}else {
					$sender->sendMessage("§cDu musst der Besitzer des Grundstücks welches du mergen willst sein!");
				}
			}
			if($direction == "south"){
				$da = $plot->X;
				$id = $plot->Z + 1;
				$plotN = $this->getPlugin()->getProvider()->getPlot($levelName, $da, $id);
				if($plotN->owner == $sender->getName() or $sender->hasPermission("myplot.admin.merge")) {
					if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
						$this->getPlugin()->unmergePlot($plot, $plotN, $sender, $direction);
						$sender->sendMessage("Deine Grundstücke wurden unmerged!");
					} else {
						$sender->sendMessage("§cDas Plot ist nicht gemerged");
					}
				}else {
					$sender->sendMessage("§cDu musst der Besitzer des Grundstücks welches du mergen willst sein!");
				}
			}
			if($direction == "east"){
				$da = $plot->X + 1;
				$id = $plot->Z;
				$plotN = $this->getPlugin()->getProvider()->getPlot($levelName, $da, $id);
				if($plotN->owner == $sender->getName() or $sender->hasPermission("myplot.admin.merge")) {
					if ($merge->getNested($sender->getPlayer()->getLevel()->getName() . ".$plot")) {
						$this->getPlugin()->unmergePlot($plot, $plotN, $sender, $direction);
						$sender->sendMessage("Deine Grundstücke wurden unmerged!");
					} else {
						$sender->sendMessage("§cDas Plot ist nicht gemerged");
					}
				}else {
					$sender->sendMessage("§cDu musst der Besitzer des Grundstücks welches du mergen willst sein!");
				}
			}
			return true;
		}
		return true;
	}
}

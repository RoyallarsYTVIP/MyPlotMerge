<?php
declare(strict_types=1);

namespace MyPlot\subcommand;

use MyPlot\Plot;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class HomeSubCommand extends SubCommand
{
    /**
     * @param CommandSender $sender
     *
     * @return bool
     */

    public function canUse(CommandSender $sender) : bool {
        return ($sender instanceof Player) and $sender->hasPermission("myplot.command.home");
    }

    /**
     * @param Player $sender
     * @param string[] $args
     *
     * @return bool
     */
    public function execute(CommandSender $sender, array $args) : bool {
        $prefix = TF::GOLD . "Plot" . TF::DARK_GRAY . TF::BOLD . " » " . TF::RESET . TF::GRAY;
        $plotNumber = 1;	$name = $sender->getName();
        if(isset($args[1]) and is_numeric($args[1])){ $plotNumber = (int) $args[1];}
        if(isset($args[0]) and is_numeric($args[0])) {
            $plotNumber = (int) $args[0];
        }else if (isset($args[0])){
            $name = array_shift($args);
            $p = $this->getPlugin()->getServer()->getPlayer($name);
            if($p !== null){ $name = $p->getName();}

        }
        $levelName = $args[2] ?? $sender->getLevel()->getFolderName();
        $plots = $this->getPlugin()->getPlotsOfPlayer($name, $levelName);
        if(empty($plots)) {
            if($name !== $sender->getName()){
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }else{
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }
            return true;
        }
        if(!isset($plots[$plotNumber - 1])) {
            if($name !== $sender->getName()){
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }else{
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }

            return true;
        }
        usort($plots, function(Plot $plot1, Plot $plot2) {
            if($plot1->levelName == $plot2->levelName) {
                return 0;
            }
            return ($plot1->levelName < $plot2->levelName) ? -1 : 1;
        });
        $plot = $plots[$plotNumber - 1];
        if($this->getPlugin()->teleportPlayerToPlot($sender, $plot)) {
            if($name !== $sender->getName()){
                $sender->sendMessage($prefix . TF::GRAY . "Du wurdest erfolgreich zu dem Grundstück " . TF::GOLD . $name . TF::GRAY . " teleportiert.");
            }else{
                $sender->sendMessage($prefix . TF::GRAY . "Du wurdest erfolgreich zu dem Grundstück " . TF::GOLD . $name . TF::GRAY . " teleportiert.");
            }
        }else{
            if($name !== $sender->getName()){
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }else{
                $sender->sendMessage($prefix . TF::GRAY . "Du konntest nicht zu deinem Grundstück teleportiert werden.");
            }

        }


        return true;
    }
}

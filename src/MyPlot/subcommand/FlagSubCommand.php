<?php

declare(strict_types=1);
namespace MyPlot\subcommand;


use MyPlot\MyPlot;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginDescription;
use pocketmine\plugin\PluginLoader;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

class FlagSubCommand extends SubCommand {
	protected $pl;
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
		return ($sender instanceof Player) and $sender->hasPermission("myplot.command.flag");
	}
	/**
	 * @param Player $sender
	 * @param string[] $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args) : bool {
		$plot = MyPlot::getInstance()->getPlotByPosition($sender);
		if($plot === null) {
			$sender->sendMessage(TextFormat::RED . $this->translateString("notinplot"));
			return true;
		}
		if($plot->owner !== $sender->getName() and !$sender->hasPermission("myplot.admin.flag")) {
			$sender->sendMessage(TextFormat::RED.$this->translateString("notowner"));
			return true;
		}



		$fdata = [];

		$fdata['title'] = '§cMyPlot§8│§7 /p falg';
		$fdata['buttons'] = [];
		$fdata['content'] = "";
		$fdata['type'] = 'form';

		$fdata['buttons'][] = ['text' => '§cZurück'];
		$fdata['buttons'][] = ['text' => '§7particle'];
		$fdata['buttons'][] = ['text' => '§7effect'];
		$fdata['buttons'][] = ['text' => '§7Truhen'];


		$pk = new ModalFormRequestPacket();
		$pk->formId = 35335;
		$pk->formData = json_encode($fdata);

		$sender->sendDataPacket($pk);

		return true;

	}
}

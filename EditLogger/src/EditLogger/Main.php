<?php

/*
 * お問い合わせはTwitterへ By Setsuna
 * twitter  >> https://twitter.com/Noah_stn/
*/

namespace EditLogger;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{

	public function onEnable()
	{
		$plugin = "EditLogger";
		$this->getLogger()->info(TextFormat::GREEN.$plugin."を読み込みました".TextFormat::BLUE." By Setsuna");
		$this->getLogger()->info(TextFormat::RED.$plugin."を二次配布するのは禁止です");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if($command->getName() == "log"){
			if (!$sender instanceof Player) return $sender->sendMessage(TextFormat::RED."Error : このコマンドはゲーム内で使用してください");
			$subCommand = strtolower(array_shift($args));
			switch ($subCommand){
				case 'save':
					$sender->sendMessage("§aSaving now...");

					$sender->sendMessage("§aSaved!");
					return true;

				default:
					$sender->sendMessage("\"/log help\" - Help command");
					return true;

			}
		}
	}

}
<?php

namespace Kit;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener{

	public function onEnable()
	{
		$plugin = "kit";
		$this->getLogger()->info(TextFormat::GREEN.$plugin."を読み込みました".TextFormat::BLUE." By Setsuna");
		$this->getLogger()->info(TextFormat::RED.$plugin."を二次配布するのは禁止です");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->PocketMoney = $this->getServer()->getPluginManager()->getPlugin("PocketMoney");
		if($this->PocketMoney === null){
			$this->getLogger()->info(TextFormat::RED ."PocketMoneyのAPIがないのでサーバーを止めます");
			$this->getServer()->shutdown();
		}else{
			$this->getLogger()->info(TextFormat::AQUA."PocketMoneyを読み込みました");
		}
	}

	public function onDesable()
	{
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if($command->getName() == "kitlist"){
			if (!$sender instanceof Player) return $sender->sendMessage("[警告] このコマンドはゲーム内で使用してください");
			$subCommand = strtolower(array_shift($args));
			switch ($subCommand){
				case "":
					$sender->sendMessage("[装備屋] /kitlist <1 or 2> でコマンド確認できます");  
				break;
				case "1":
					$sender->getPlayer()->sendMessage("===================================");
					$sender->getPlayer()->sendMessage("Kit 一覧表 1ページ");
					$sender->getPlayer()->sendMessage("| /kit ls -> 革装備 [500PM]");
					$sender->getPlayer()->sendMessage("| /kit gs -> 金装備 [1500PM]");
					$sender->getPlayer()->sendMessage("| /kit is -> 鉄装備 [3000PM]");
					$sender->getPlayer()->sendMessage("| /kit ds -> ダイヤ装備 [5000PM]");
					$sender->getPlayer()->sendMessage("===================================");
				break;
				case "2":
					$sender->getPlayer()->sendMessage("===================================");
					$sender->getPlayer()->sendMessage("Kit 一覧表 2ページ");
					$sender->getPlayer()->sendMessage("| /kit fs -> 無料装備 [Free]");
					$sender->getPlayer()->sendMessage("===================================");
				break;
				default:
				$sender->sendMessage("\"/kitlist $subCommand\" というコマンドは存在しません");
				$sender->sendMessage("[装備屋] /kitlist <1 or 2> でコマンド確認できます");  
				break;
			}
		}
		if($command->getName() == "kit"){
			if (!$sender instanceof Player) return $sender->sendMessage("このコマンドはゲーム内で使用してください");
			$subCommand = strtolower(array_shift($args));
			switch ($subCommand){
				case "":
				$sender->sendMessage("[装備屋] /kitlist <1 or 2> でコマンド確認できます");
				break;

				case "ls":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 500;
				$money = $this->PocketMoney->getMoney($name);
				if($money < $price){
					$sender->sendMessage("[装備屋] お金が足りないため購入できませんでした");
				break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					$player->getInventory()->setArmorItem(0,Item::get(298,0,1));
					$player->getInventory()->setArmorItem(1,Item::get(299,0,1));
					$player->getInventory()->setArmorItem(2,Item::get(300,0,1));
					$player->getInventory()->setArmorItem(3,Item::get(301,0,1));
					$player->getInventory()->sendArmorContents($player);
					$sender->sendMessage("[装備屋] 革装備を購入しました！");
				}
				break;

				case "gs":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 1500;
				$money = $this->PocketMoney->getMoney($name);
				if($money < $price){
					$sender->sendMessage("[装備屋] お金が足りないため購入できませんでした");
				break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					$player->getInventory()->setArmorItem(0,Item::get(314,0,1));
					$player->getInventory()->setArmorItem(1,Item::get(315,0,1));
					$player->getInventory()->setArmorItem(2,Item::get(316,0,1));
					$player->getInventory()->setArmorItem(3,Item::get(317,0,1));
					$player->getInventory()->sendArmorContents($player);
					$sender->sendMessage("[装備屋] 金装備を購入しました！");
				}
				break;

				case "is":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 3000;
				$money = $this->PocketMoney->getMoney($name);
				if($money < $price){
					$sender->sendMessage("[装備屋] お金が足りないため購入できませんでした");
				break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					$player->getInventory()->setArmorItem(0,Item::get(306,0,1));
					$player->getInventory()->setArmorItem(1,Item::get(307,0,1));
					$player->getInventory()->setArmorItem(2,Item::get(308,0,1));
					$player->getInventory()->setArmorItem(3,Item::get(309,0,1));
					$player->getInventory()->sendArmorContents($player);
					$sender->sendMessage("[装備屋] 鉄装備を購入しました！");
				}
				break;

				case "ds":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 1500;
				$money = $this->PocketMoney->getMoney($name);
				if($money < $price){
					$sender->sendMessage("[装備屋] お金が足りないため購入できませんでした");
				break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					$player->getInventory()->setArmorItem(0,Item::get(310,0,1));
					$player->getInventory()->setArmorItem(1,Item::get(311,0,1));
					$player->getInventory()->setArmorItem(2,Item::get(312,0,1));
					$player->getInventory()->setArmorItem(3,Item::get(313,0,1));
					$player->getInventory()->sendArmorContents($player);
					$sender->sendMessage("[装備屋] ダイヤ装備を購入しました！");
				}
				break;

				case "fs":
				$player = $sender->getPlayer();
				$player->getInventory()->setArmorItem(1,Item::get(299,0,1));
				$player->getInventory()->sendArmorContents($player);
				$sender->sendMessage("[装備屋] 無料装備を購入しました！");
				break;

				default:
				$sender->sendMessage("\"/kit $subCommand\" というコマンドは存在しません");
				$sender->sendMessage("[装備屋] /kit <1 or 2> でコマンド確認できます");  
				break;
			}
		}
	}

}
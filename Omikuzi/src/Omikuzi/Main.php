<?php

/*
 * お問い合わせはTwitterへ By Setsuna
 * homepage >> http://site.pmmp.link/
 * twitter  >> https://twitter.com/Noah_stn/
*/

namespace Omikuzi;

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
		$plugin = "Omikuzi";
		$this->getLogger()->info(TextFormat::GREEN.$plugin."を読み込みました".TextFormat::BLUE." By Setsuna");
		$this->getLogger()->info(TextFormat::RED.$plugin."を二次配布するのは禁止です");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->PocketMoney = $this->getServer()->getPluginManager()->getPlugin("PocketMoney");//ここでPocketMoney呼び出し
		if($this->PocketMoney === null){
			$this->getLogger()->info(TextFormat::RED ."PocketMoneyのAPIがないのでサーバーを止めます");
			$this->getServer()->shutdown();
		}else{
			$this->getLogger()->info(TextFormat::AQUA."PocketMoneyを読み込みました");
		}
	}

	public function onCommand(CommandSender $sender, Command $command, $label, array $args)
	{
		if($command->getName() == "rand"){
			if (!$sender instanceof Player) return $sender->sendMessage(TextFormat::RED."[エラー] このコマンドはゲーム内で使用してください");
			$subCommand = strtolower(array_shift($args));
			switch ($subCommand){
/* ---------------------- コマンド ---------------------- */

				case "":
				case "help":
				$sender->sendMessage("=====================================");
				$sender->sendMessage("オミクジリスト");
				$sender->sendMessage(" |/rand sword [1000PM] 剣のオミクジ");
				$sender->sendMessage(" |/rand wood  [500PM]  原木のオミクジ 50個");
				$sender->sendMessage("=====================================");
				break;

				case "sword":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 1000;//値段
				$diamond = Item::get(276, 0, 1);
				$gold = Item::get(283, 0, 1);
				$iron = Item::get(267, 0, 1);
				$wood = Item::get(268, 0, 1);
				$rand = rand(1, 4);//乱数
				$money = $this->PocketMoney->getMoney($name);//PMからデータを取得
				if($money < $price){
					$sender->sendMessage("[オミクジ] お金が足りないためオミクジできませんでした");
					break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					switch($rand){
						case 1:
						$player->getInventory()->addItem($diamond);
						$sender->sendMessage("[オミクジ] ダイヤの剣があたりました!");
						break;
						case 2:
						$player->getInventory()->addItem($gold);
						$sender->sendMessage("[オミクジ] 金の剣があたりました!");
						break;
						case 3:
						$player->getInventory()->addItem($iron);
						$sender->sendMessage("[オミクジ] 鉄の剣があたりました!");
						break;
						case 4:
						$player->getInventory()->addItem($wood);
						$sender->sendMessage("[オミクジ] 木の剣があたりました!");
						break;
					}
				}
				break;

				case "wood":
				$player = $sender->getPlayer();
				$name = $player->getName();
				$price = 500;//値段
				$oak = Item::get(17, 0, 50);
				$spruce = Item::get(17, 1, 50);
				$birch = Item::get(17, 2, 50);
				$jangle = Item::get(17, 3, 50);
				$rand = rand(1, 4);//乱数
				$money = $this->PocketMoney->getMoney($name);//PMからデータを取得
				if($money < $price){
					$sender->sendMessage("[オミクジ] お金が足りないためオミクジできませんでした");
					break;
				}else{
					$this->PocketMoney->grantMoney($name, -$price);
					switch($rand){
						case 1:
						$player->getInventory()->addItem($oak);
						$sender->sendMessage("[オミクジ] オークの原木があたりました!");
						break;
						case 2:
						$player->getInventory()->addItem($spruce);
						$sender->sendMessage("[オミクジ] 松の原木があたりました!");
						break;
						case 3:
						$player->getInventory()->addItem($birch);
						$sender->sendMessage("[オミクジ] 白樺の原木があたりました!");
						break;
						case 4:
						$player->getInventory()->addItem($jangle);
						$sender->sendMessage("[オミクジ] ジャングルの木があたりました!");
						break;
					}
				}
				break;



/* ----------------------- コマンド ---------------------- */
				default:
				$sender->sendMessage("\"/rand $subCommand\" というコマンドは存在しません");
				break;

			}
		}
	}

}
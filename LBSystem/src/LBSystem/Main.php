<?php

namespace LBSystem;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements Listener{

	function onEnable() {
		$plugin      = "LBSystem";
		$version     = "_0.1.6 beta";
		$this->bdata = new Config("BData.data", Config::YAML, []);
		$this->ldata = new Config("LData.data", Config::YAML, []);
		$this->getLogger()->info("§b----------------------------------------------------------------");
		$this->getLogger()->info("§d".$plugin." 情報詳細");
		$this->getLogger()->info("§e| §a".$plugin.$version."を読み込みました §bMade by Setsuna");
		$this->getLogger()->info("§e| §4§l§n二次配布をすることはライセンス違反ですのでおやめください");
		$this->getLogger()->info("§e| §a不具合などは §bTwitter §e@Noah_stn §aにご連絡お願いします");
		$this->getLogger()->info("§b----------------------------------------------------------------");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	function onDisable() { $this->ldata->save(); }

	function Join (PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		$name   = $player->getName();
		$ip     = $player->getAddress();
		$host   = gethostbyaddr($ip);
		$hostp  = $this->hp($host);
		$id     = $player->loginData["clientId"];
		$idp    = $this->hp($id);
		$data   = $this->ldata->get(strtolower($name));
#		if () {
			if ($data != false) {
				if ($data["ID"] == $idp || $data["IP"] == $ip) {
					$player->sendMessage("§dLBSystem §e| §aログイン認証が無事完了しました");
				}else{
					$player->kick("§dLBSystem §e| §aログインデータと一致しないためKickしました");
					$this->getLogger()->info("§a端末IDとIPが一致しないため、".$name."をサーバーからKickしました");
				}
			}else{
				$this->ldata->set(strtolower($name), ["IP" => $ip, "ID" => $idp, "HOST" => $hostp]);
				$this->ldata->save;
				$player->sendMessage("§dLBSystem §e| §a登録が無事完了しました");
			}
#		}else{

#		}
	}

/*
	function onCommand (CommandSender $sender, Command $command, $label, array $params ) {
		switch ($command->getName()) {
			case "lbs":
			switch ($params[0]) {

				case '1':
					$sender->sendMessage("§aCommand 1");
					break;

				case '2':
					$sender->sendMessage("§aCommand 2");
					break;

				case '3':
					$sender->sendMessage("§aCommand 3");
					break;

				case "help":
				case "":
					$sneder->sendMessage("§b------------------------------");
					$sender->sendMessage("§dLBSystem");
					$sender->sendMessage("§e  /lbs 1 §f>> §ecommand 1");
					$sender->sendMessage("§e  /lbs 2 §f>> §ecommand 2");
					$sender->sendMessage("§e  /lbs 3 §f>> §ecommand 3");
					$sneder->sendMessage("§b------------------------------");
					break;

				default:
					$sender->sendMessage("§cコマンドが違います。§e/lbs§cでコマンドを確認してください。");
					break;
			}// breakでswitchを抜ける
			return true;
		}
	}
*/

	public function hp($str) { 
		return bin2hex($str);
	}
}
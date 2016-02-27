<?php

/*
 * < For developer >
 * このプラグインでは[配列] [グローバル変数]を使った例として配布を行いました。
 *
 * < Warning >
 * 二次配布などは禁止とします。
 * また、中身が同じものもそれに該当します
 * 配列の[参考]にご閲覧ください。
 *
 * < About >
 * Twitter  @Noah_stn
 * Server   IP:setsuna.info Port:19132
 *
 */

namespace setsuna;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;

class Main extends PluginBase implements Listener{

	// 起動時の処理
	public function onEnable ()
	{
		$this->spam['name'] = null;
		$this->count = 8;

		$this->getLogger()->info("§bSpamBlocker Enabling!");
		$this->getLogger()->info("§7---------------------");
		$this->getLogger()->info("§4SPAMの対象");
		$this->getLogger()->info("§f* §a$this->count秒間の連続投稿");
		$this->getLogger()->info("§f* §a同じ内容の投稿");
		$this->getLogger()->info("§7---------------------");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	// プレイヤーのログイン時の処理
	public function onJoin (PlayerJoinEvent $e)
	{
		$player = $e->getPlayer();
		$name   = $player->getName();
		$this->msg[$name] = null;
	}

	// プレイヤーのチャット時の処理
	public function onChat (PlayerChatEvent $e)
	{
		// 代入
		$player = $e->getPlayer();
		$name   = $player->getName();
		$msg    = $e->getMessage();

		if($this->msg[$name] === $msg) {
			// 同じチャットをした場合
			$e->setCancelled();
			$player->sendMessage("§e? §4同じチャットを連続で投稿することはできません。");
		}elseif($this->spam['name'] === $name) {
			// 設定された時間以内に自分が連続してチャットした場合
			$e->setCancelled();
			$player->sendMessage("§e? §4チャットの連続投稿はできません。");
		}else{
			// Spamと判定されなかった場合
			$this->spam['name'] = $name;
			$this->msg[$name]   = $msg;
			$e->setMessage($msg);
			Server::getInstance()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, 'CleanTask'], []), 20 * $this->count);
		}
	}

	// 連続投稿の解除()
	public function CleanTask ()
	{
		$this->spam['name'] = null;
	}
}
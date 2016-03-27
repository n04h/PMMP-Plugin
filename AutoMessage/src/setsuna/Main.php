<?php

/*
 * < Warning >
 * 二次配布などは禁止とします。
 * また、中身が同じものもそれに該当します
 *
 * < About >
 * Twitter  @Noah_stn
 *
 */

namespace setsuna;

//Default
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;

//Task
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;

class Main extends PluginBase implements Listener{

	// 起動時の処理
	public function onEnable ()
	{
		$this->server = Server::getInstance();
		$this->server->getPluginManager()->registerEvents($this, $this);

        if (!file_exists($this->getDataFolder())) @mkdir($this->getDataFolder(), 0740, true);
        $this->msg = new Config($this->getDataFolder() . "message.yml", Config::YAML,
        [
            'time' => 60,
            0 => 'この部分にメッセージを入力してください。',
            1 => '使わないところは下のようにしてください',
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null,
            7 => null,
            8 => null,
            9 => null
        ]);
        $this->msg->save();

        $this->server->getScheduler()->scheduleRepeatingTask(new CallbackTask([$this, 'AutoMessage']), 20 * $this->config->get('time'));
	}

	// メッセージをランダムで選んで表示
	public function AutoMessage ()
	{
		while (1) {
			$n = mt_rand(0,9);
			if(!empty($n)) break;
		}
		$this->server->broadcastMessage($this->config->get($n));
	}
}

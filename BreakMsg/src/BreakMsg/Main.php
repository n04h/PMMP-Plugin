<?php

/*
 *   _|_|_|              _|                                              
 * _|          _|_|    _|_|_|_|    _|_|_|  _|    _|  _|_|_|      _|_|_|  
 *   _|_|    _|_|_|_|    _|      _|_|      _|    _|  _|    _|  _|    _|  
 *       _|  _|          _|          _|_|  _|    _|  _|    _|  _|    _|  
 * _|_|_|      _|_|_|      _|_|  _|_|_|      _|_|_|  _|    _|    _|_|_|  
 *
 */

namespace BreakMsg;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

class Main extends PluginBase implements Listener{

	//サーバー起動時に呼び出される処理
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	//ブロック破壊時に呼び出される処理
	public function onBlockBreak(BlockBreakEvent $event){
		$player = $event->getPlayer();
		$player->sendMessage("ブロックは壊せません！はは！(ミッキー風");//メッセージ
		if($player->isOp()){
		}else{
			$event->setCancelled();//壊すのをキャンセルさせるとこ
		}
	}

}
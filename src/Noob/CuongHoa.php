<?php

namespace Noob;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Server;
use Noob\commands\{CuongHoaCommand, ItemCHCommand};
use pocketmine\math\Vector3;
use pocketmine\item\StringToItemParser;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\item\{Sword, Pickaxe, Axe};

class CuongHoa extends PluginBase {

	public static $instance;
    public $cuonghoa;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable(): void{
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register("/cuonghoa", new CuongHoaCommand($this));
        $this->getServer()->getCommandMap()->register("/itemcuonghoa", new ItemCHCommand($this));
        $this->cuonghoa = new Config($this->getDataFolder() . "cuonghoa.yml", Config::YAML);
        $this->loadConfig();
        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
	}

    public function getManager(){
        return $this->cuonghoa;
    }

    public function loadConfig(){
        if(!$this->getManager()->exists("Server-Config")){
            $this->getManager()->set("Server-Config", [
                "Name-Item" => "§l§6> §eĐá Cường Hóa §6<",
                "Ti-Le-Thanh-Cong" => 50
            ]);
            $this->getManager()->save();
        }
    }

    public function addItem(Player $player, int $count){
        $item = StringToItemParser::getInstance()->parse("diamond")->setCount($count)->setCustomName((string)$this->getManager()->getNested("Server-Config.Name-Item"));
        if($player->getInventory()->canAddItem($item)){
            $player->getInventory()->addItem($item);
        }
        else{
            $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
        }
    }

    public function chance(float $chance): bool{
        if($chance == 100) return true;
        $rate = mt_rand(1, 100);
        if($chance < $rate) return false;
        return true;
    }
}
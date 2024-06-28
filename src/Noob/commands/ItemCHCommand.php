<?php

namespace Noob\commands;

use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use Noob\CuongHoa;
use pocketmine\Server;
use Noob\Libs;

class ItemCHCommand extends Command implements PluginOwned{
    private CuongHoa $plugin;
    public string $prefix = "§l§eHệ Thống §6> ";

    public function __construct(CuongHoa $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("itemcuonghoa", "Lấy Đá Cường Hóa Nguyên Bản", null, ['itemch']);
        $this->setPermission("cuonghoa.give");
    }

    public function execute(CommandSender $player, string $label, array $args){
        if (!$player instanceof Player) {
            $this->getOwningPlugin()->getLogger()->notice("Xin hãy sử dụng lệnh trong trò chơi");
            return 1;
        }
        if(count($args) == 0 or count($args) > 1){
            $player->sendMessage($this->prefix . "§6/itemcuonghoa <số lượng>");
            return 1;
        }
        else{
            if(isset($args[0])){
                if(is_numeric($args[0])){
                    $this->plugin->addItem($player, (int)$args[0]);
                    $player->sendMessage($this->prefix . "§6Bạn Đã Nhận Được Vật Phẩm Cường Hóa !");
                    Libs::getInstance()->sendSound($player, "random.levelup");
                }
                else{
                    $player->sendMessage($this->prefix . "§6/itemcuonghoa <số lượng>");
                }
            }
            else{
                $player->sendMessage($this->prefix . "§6/itemcuonghoa <số lượng>");
            }
        }
    }

    public function getOwningPlugin(): CuongHoa{
        return $this->plugin;
    }
}
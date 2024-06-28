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
use Noob\inventory\CHMenu;

class CuongHoaCommand extends Command implements PluginOwned{
    private CuongHoa $plugin;
    public string $prefix = "§l§eHệ Thống §6> ";

    public function __construct(CuongHoa $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("cuonghoa", "Cường Hóa", null, []);
        $this->setPermission("cuonghoa.cmd");
    }

    public function execute(CommandSender $player, string $label, array $args){
        if (!$player instanceof Player) {
            $this->getOwningPlugin()->getLogger()->notice("Xin hãy sử dụng lệnh trong trò chơi");
            return 1;
        }
        $inv = new CHMenu;
        $inv->openMenu($player);
    }

    public function getOwningPlugin(): CuongHoa{
        return $this->plugin;
    }
}
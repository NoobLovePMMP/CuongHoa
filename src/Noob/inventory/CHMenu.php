<?php

namespace Noob\inventory;

use pocketmine\plugin\PluginBase;
use pocketmine\command\{Command, CommandSender, CommandExecutor};
use pocketmine\console\ConsoleCommandSender;
use pocketmine\player\Player;
use pocketmine\item\StringToItemParser;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\transaction\InvMenuTransaction;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\enchantment\EnchantmentInstance;
use muqsit\customsizedinvmenu\CustomSizedInvMenu;
use Noob\CuongHoa;
use Noob\Libs;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;

class CHMenu {

    public $prefix = "§l§eHệ Thống §6> ";
  
    public function openMenu(Player $player): void{
        $menu = CustomSizedInvMenu::create(54);
        $menu->setName("§l§eCường Hóa");
        $inventory = $menu->getInventory();
        $item = StringToItemParser::getInstance()->parse("anvil")->setCustomName("§aCường Hóa");
        $enchant = StringToEnchantmentParser::getInstance()->parse("unbreaking");
        $item->addEnchantment(new EnchantmentInstance($enchant, 1000));
        $inventory->setItem(40, $item);
        for ($i=0;$i<=53;$i++){
            if(!in_array($i, [20, 24, 40])){
                $inventory->setItem($i, StringToItemParser::getInstance()->parse("white_stained_glass_pane")->setCustomName("§r§7  "));
            }
        }
        $menu->setListener(function(InvMenuTransaction $transaction) use ($player): InvMenuTransactionResult{
            $itemClicked = $transaction->getItemClicked();
            $itemClickedWith = $transaction->getItemClickedWith();
            $action = $transaction->getAction();
            $ngoc = $action->getInventory()->getItem(20);
            $item = $action->getInventory()->getItem(24);
            $ngoc_count = $ngoc->getCount();
            if($itemClicked->getName() == "§aCường Hóa"){
                if(!$ngoc->isNull() && !$item->isNull()){
                    if($ngoc->getCustomName() == CuongHoa::getInstance()->getManager()->getNested("Server-Config.Name-Item")){
                        if($ngoc->hasEnchantments()){
                            if(!$item->hasEnchantments()){
                                if($item instanceof Tool){
                                    $vien = 0;
                                    $count = $ngoc->getCount();
                                    for ($i = 1; $i <= $count; $i++){
                                        $tile = CuongHoa::getInstance()->getManager()->getNested("Server-Config.Ti-Le-Thanh-Cong");
                                        if(CuongHoa::getInstance()->chance((float)$tile)){
                                            $vien = $i;
                                            foreach($ngoc->getEnchantments() as $data){
                                                $item->addEnchantment($data);

                                            }
                                            $player->sendMessage($this->prefix . "§fCường Hóa Thành Công !");
                                            Libs::getInstance()->sendSound($player, "random.levelup");
                                            break;
                                        }
                                        else{
                                            $player->sendMessage($this->prefix . "§fCường Hóa   Bại !");
                                            Libs::getInstance()->sendSound($player, "random.explode");
                                        }
                                    }
                                    $count_ngoc = $ngoc->setCount($count - $vien);
                                    if($player->getInventory()->canAddItem($ngoc)){
                                        $player->getInventory()->addItem($count_ngoc);
                                    }
                                    else{
                                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $count_ngoc);
                                    }
                                    if($player->getInventory()->canAddItem($item)){
                                        $player->getInventory()->addItem($item);
                                    }
                                    else{
                                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                                    }
                                }
                                else{
                                    if($player->getInventory()->canAddItem($ngoc)){
                                        $player->getInventory()->addItem($ngoc);
                                    }
                                    else{
                                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $ngoc);
                                    }
                                    if($player->getInventory()->canAddItem($item)){
                                        $player->getInventory()->addItem($item);
                                    }
                                    else{
                                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                                    }
                                    $player->sendMessage($this->prefix . "§fBạn Không Thể Cường Hóa Vật Phẩm Này !");
                                }
                            }
                            else{
                                if($player->getInventory()->canAddItem($ngoc)){
                                    $player->getInventory()->addItem($ngoc);
                                }
                                else{
                                    $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $ngoc);
                                }
                                if($player->getInventory()->canAddItem($item)){
                                    $player->getInventory()->addItem($item);
                                }
                                else{
                                    $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                                }
                                $player->sendMessage($this->prefix . "§fVật Phẩm Cần Là 1 Item Bình Thường");
                            }
                        }
                        else{
                            if($player->getInventory()->canAddItem($ngoc)){
                                $player->getInventory()->addItem($ngoc);
                            }
                            else{
                                $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $ngoc);
                            }
                            if($player->getInventory()->canAddItem($item)){
                                $player->getInventory()->addItem($item);
                            }
                            else{
                                $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                            }
                            $player->sendMessage($this->prefix . "§fNgọc Này Không Được Phù Phép !");
                        }
                    }
                    else{
                        if($player->getInventory()->canAddItem($ngoc)){
                            $player->getInventory()->addItem($ngoc);
                        }
                        else{
                            $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $ngoc);
                        }
                        if($player->getInventory()->canAddItem($item)){
                            $player->getInventory()->addItem($item);
                        }
                        else{
                            $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                        }
                        $player->sendMessage($this->prefix . "§fĐây Không Phải Ngọc Cường Hóa !");
                    }
                }
                else{
                    if($player->getInventory()->canAddItem($ngoc)){
                        $player->getInventory()->addItem($ngoc);
                    }
                    else{
                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $ngoc);
                    }
                    if($player->getInventory()->canAddItem($item)){
                        $player->getInventory()->addItem($item);
                    }
                    else{
                        $player->getPosition()->getWorld()->dropItem(new Vector3($player->getPosition()->getX(), $player->getPosition()->getY(), $player->getPosition()->getZ()), $item);
                    }
                    $player->sendMessage($this->prefix . "§fVui Lòng Gắn Vật Phẩm và Ngọc Vào !");
                }
                $player->removeCurrentWindow();
                return $transaction->discard();
            }
            if($itemClicked->getName() == "§r§7  "){
                Libs::getInstance()->sendSound($player, "mob.horse.angry");
                return $transaction->discard();
            }
            return $transaction->continue();
        });
        $menu->send($player);
    }
}
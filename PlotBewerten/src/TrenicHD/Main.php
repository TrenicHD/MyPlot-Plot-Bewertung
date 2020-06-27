<?php

namespace TrenicHD;


use pocketmine\block\Block;
use pocketmine\block\Sandstone;
use pocketmine\entity\Effect;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Bread;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\IronBoots;
use pocketmine\item\IronChestplate;
use pocketmine\item\IronHelmet;
use pocketmine\item\IronLeggings;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV2;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use jojoe77777\FormAPI;
use pocketmine\entity\EffectInstance;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\level\sound\AnvilUseSound;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\ItemFactory;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\server\QueryRegenerateEvent;

class Main extends PluginBase implements Listener
{

    public $prefix = "≫§bPlot§0-§aBewerten";

    public function onLoad()
    {
        $this->getLogger()->info(TextFormat::AQUA . "Plugin §bPlot§0-§aBewerten wird geladen...");
        sleep(1);
    }
        

    public function onDisable()
    {
        $this->getLogger()->warning(TextFormat::RED . "Plugin Deaktiviert");
        $this->getLogger()->info(TextFormat::RED . "  ___   _         _           ___                              _                ");
        $this->getLogger()->info(TextFormat::RED . " | _ \ | |  ___  | |_   ___  | _ )  ___  __ __ __  ___   _ _  | |_   ___   _ _  ");
        $this->getLogger()->info(TextFormat::RED . " |  _/ | | / _ \ |  _| |___| | _ \ / -_) \ V  V / / -_) | '_| |  _| / -_) | ' \ ");
        $this->getLogger()->info(TextFormat::RED . " |_|   |_| \___/  \__|       |___/ \___|  \_/\_/  \___| |_|    \__| \___| |_||_|");
    }


    public function onEnable()
    {
        $this->getLogger()->info(TextFormat::GREEN . "Plugin Plot-Bewerten Aktiv!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "  ___   _         _           ___                              _                ");
        $this->getLogger()->info(TextFormat::GREEN . " | _ \ | |  ___  | |_   ___  | _ )  ___  __ __ __  ___   _ _  | |_   ___   _ _  ");
        $this->getLogger()->info(TextFormat::GREEN . " |  _/ | | / _ \ |  _| |___| | _ \ / -_) \ V  V / / -_) | '_| |  _| / -_) | ' \ ");
        $this->getLogger()->info(TextFormat::GREEN . " |_|   |_| \___/  \__|       |___/ \___|  \_/\_/  \___| |_|    \__| \___| |_||_|");
        $this->getLogger()->info(TextFormat::GOLD . " Plugin by TrenicHD YouTube: https://www.youtube.com/TrenicHD");
        $this->getLogger()->info(TextFormat::GOLD . " GitHub -> https://github.com/TrenicHD");
    }

    public function onSignCange(SignChangeEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();
        if ($player->hasPermission("bt.use")) {
            if (strtolower($event->getLine(0) === "Plot")) {
                if ($event->getLine(1) === "1") {
                    $event->setLine(0, "§bPlot-Bewertung");
                    $event->setLine(1, "Bewertung");
                    $event->setLine(2, "§4 [ 1 ]");
                    $event->setLine(3, "§4 Sehr schlecht!");
                    $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                    $player->addTitle("§a ✔");
                    $player->getLevel()->addSound(new EndermanTeleportSound($player));
                } else {
                    if ($event->getLine(1) === "2") {
                        $event->setLine(0, "§bPlot-Bewertung");
                        $event->setLine(1, "Bewertung");
                        $event->setLine(2, "§4 [ 2 ]");
                        $event->setLine(3, "§cSchlecht!");
                        $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                        $player->getLevel()->addSound(new EndermanTeleportSound($player));
                        $player->addTitle("§a ✔");
                    } else {
                        if ($event->getLine(1) === "3") {
                            $event->setLine(0, "§bPlot-Bewertung");
                            $event->setLine(1, "Bewertung");
                            $event->setLine(2, "§5 [ 3 ]");
                            $event->setLine(3, "§5 Befriedigend");
                            $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                            $player->getLevel()->addSound(new EndermanTeleportSound($player));
                            $player->addTitle("§a ✔");
                        } else {
                            if ($event->getLine(1) === "4") {
                                $event->setLine(0, "§bPlot-Bewertung");
                                $event->setLine(1, "Bewertung");
                                $event->setLine(2, "§5 [ 4 ]");
                                $event->setLine(3, "§5 Befriedigend");
                                $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                $player->addTitle("§a ✔");
                            } else {
                                if ($event->getLine(1) === "5") {
                                    $event->setLine(0, "§bPlot-Bewertung");
                                    $event->setLine(1, "Bewertung");
                                    $event->setLine(2, "§6[ 5 ]");
                                    $event->setLine(3, "§6 Naja");
                                    $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                    $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                    $player->addTitle("§a ✔");

                                } else {
                                    if ($event->getLine(1) === "6") {
                                        $event->setLine(0, "§bPlot-Bewertung");
                                        $event->setLine(1, "Bewertung");
                                        $event->setLine(2, "§6[ 6 ]");
                                        $event->setLine(3, "§6 Naja");
                                        $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                        $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                        $player->addTitle("§a ✔");

                                    } else {
                                        if ($event->getLine(1) === "7") {
                                            $event->setLine(0, "§bPlot-Bewertung");
                                            $event->setLine(1, "Bewertung");
                                            $event->setLine(2, "§a[ 7 ]");
                                            $event->setLine(3, "§2 Gut!");
                                            $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                            $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                            $player->addTitle("§a ✔");

                                        } else {
                                            if ($event->getLine(1) === "8") {
                                                $event->setLine(0, "§bPlot-Bewertung");
                                                $event->setLine(1, "Bewertung");
                                                $event->setLine(2, "§a[ 8 ]");
                                                $event->setLine(3, "§2 Gut!");
                                                $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                                $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                                $player->addTitle("§a ✔");

                                            } else {
                                                if ($event->getLine(1) === "9") {
                                                    $event->setLine(0, "§bPlot-Bewertung");
                                                    $event->setLine(1, "Bewertung");
                                                    $event->setLine(2, "§2[ 9 ]");
                                                    $event->setLine(3, "§2 Gut!");
                                                    $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                                    $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                                    $player->addTitle("§a ✔");

                                                } else {
                                                    if ($event->getLine(1) === "10") {
                                                        $event->setLine(0, "§bPlot-Bewertung");
                                                        $event->setLine(1, "Bewertung");
                                                        $event->setLine(2, "§b[ 10 ]");
                                                        $event->setLine(3, "§2 Sehr Gut!");
                                                        $player->sendMessage("$this->prefix §a Du hast erfolgreich das Plot Bewertet!");
                                                        $player->getLevel()->addSound(new EndermanTeleportSound($player));
                                                        $player->addTitle("§a ✔");

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $player->sendMessage("$this->prefix §c Du hast dafür keine Rechte!");
            $player->addTitle("§c ✘");
        }
    }

    public function onCommand(CommandSender $player, Command $cmd, string $label, array $args): bool
    {
        switch ($cmd->getName()){
            case "pthelp":
                if ($player->hasPermission("pthelp.use")){
                    if ($player instanceof Player){
                        $this->Help($player);
                    }
                    break;
                }
        }
        return true;
    }

    public function Help($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null){
                return true;
            }
            switch ($result){
                case 0:
                    $this->Text($player);
            }

            switch ($result){
                case 1:
                    $player->sendMessage("§c===========================");
                    $player->sendMessage("");
                    $player->sendMessage("§61. Setze ein Schild");
                    $player->sendMessage("");
                    $player->sendMessage("§62. Schreibe in Line 1 Plot");
                    $player->sendMessage("");
                    $player->sendMessage("§63. Schreibe in Line 2 eine Zahl 1-10 (1 = Schlecht 10 = Sehr Gut) ");
                    $player->sendMessage("");
                    $player->sendMessage("§64. Schild Platzieren / Enter");
                    $player->sendMessage("§c===========================");
            }
        });
        $form->setTitle("§bMenü");
        $form->setContent("§aHilfe Menü für's Plot-Bewerten\n\n§bWie möchtest du deine Hilfe sehen?");
        $form->addButton("§bText");
        $form->addButton("§aMessage");
        $form->sendToPlayer($player);
        return true;
    }

    public function Text($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null){
                return true;
            }
            switch ($result){
                case 0:
                    $player->sendMessage("$this->prefix §c Du hast das Help-Menü Verlassen!");
            }
        });
        $form->setTitle("§bMenü");
        $form->setContent("§a 1. Nehme ein Schild und Platziere ihn! \n 2. Schreibe in die erste Line Plot \n in die 2 Line Deine Bewertung\n (1-10) 1 = Schlecht 10 Sehr Gut! \n 3. Platzieren");
        $form->addButton("§cVerlassen");
        $form->sendToPlayer($player);
        return true;
    }


}
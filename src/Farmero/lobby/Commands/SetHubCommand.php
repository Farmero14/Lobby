<?php

declare(strict_types=1);

namespace Farmero\lobby\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\lobby\Lobby;

class SetHubCommand extends Command {

    private $plugin;

    public function __construct(Lobby $plugin) {
        parent::__construct("sethub");
        $this->setLabel("sethub");
        $this->setDescription("Set the servers lobby");
        $this->setAliases(["setspawn", "setlobby"]);
        $this->setPermission("lobby.cmd.sethub");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game!");
            return false;
        }

        $playerPosition = $sender->getPosition();
        $worldName = $sender->getWorld()->getFolderName();
        $this->plugin->getHubManager()->setHubLocation($playerPosition, $worldName);
        $sender->sendMessage("Hub location set, The location is your postion!");
        return true;
    }
}

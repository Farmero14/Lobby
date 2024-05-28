<?php

declare(strict_types=1);

namespace Farmero\lobby\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\lobby\Lobby;

class UpdateHubCommand extends Command {

    private $plugin;

    public function __construct(Lobby $plugin) {
        parent::__construct("updatehub");
        $this->setLabel("updatehub");
        $this->setDescription("Update the server hub");
        $this->setAliases(["updatespawn", "updatelobby"]);
        $this->setPermission("lobby.cmd.updatehub");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game!");
            return false;
        }

        $this->hubManager->updateHubLocation($sender->getPosition(), $sender->getWorld()->getFolderName());
        $sender->sendMessage("Hub location updated!");
        return true;
    }
}
<?php

declare(strict_types=1);

namespace Farmero\lobby\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use Farmero\lobby\Lobby;

class HubCommand extends Command {

    private $plugin;

    public function __construct(Lobby $plugin) {
        parent::__construct("hub");
        $this->setLabel("hub");
        $this->setDescription("Teleport to the lobby");
        $this->setAliases(["spawn", "lobby"]);
        $this->setPermission("lobby.cmd.hub");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game!");
            return false;
        }

        $this->plugin->getHubManager()->teleportPlayerToHub($sender);
        $sender->sendMessage("Teleported to the hub!");
        $sender->sendTitle("Teleported!");
        $sender->sendSubtitle("Peaceful spawn:)");
        return true;
    }
}
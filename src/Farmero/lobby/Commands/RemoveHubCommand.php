<?php

declare(strict_types=1);

namespace Farmero\lobby\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Farmero\lobby\Lobby;

class RemoveHubCommand extends Command {

    private $plugin;

    public function __construct(Lobby $plugin) {
        parent::__construct("removehub");
        $this->setLabel("removehub");
        $this->setDescription("Remove the hub");
        $this->setAliases(["removelobby", "removespawn"]);
        $this->setPermission("lobby.cmd.removehub");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        $this->plugin->getHubManager()->removeHubLocation();
        $sender->sendMessage("Hub location removed!");
        return true;
    }
}

<?php

declare(strict_types=1);

namespace Farmero\lobby;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use Farmero\lobby\Commands\HubCommand;
use Farmero\lobby\Commands\SetHubCommand;
use Farmero\lobby\Commands\RemoveHubCommand;
use Farmero\lobby\Commands\UpdateHubCommand;

use Farmero\lobby\HubManager;

class Lobby extends PluginBase implements Listener {

    private $hubManager;

    public function onEnable(): void {
        $this->hubManager = new HubManager($this->getDataFolder());

        $this->getServer()->getCommandMap()->registerAll("Lobby", [
	    new HubCommand($this->hubManager),
	    new SetHubCommand($this->hubManager),
            new RemoveHubCommand($this->hubManager),
            new UpdateHubCommand($this->hubManager)
	    ]);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function getHubManager(): HubManager {
        return $this->hubManager;
    }
}

<?php

declare(strict_types=1);

namespace Farmero\lobby;

use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\World;
use pocketmine\Server;

class HubManager {

    private string $filePath;
    private array $hubLocation;

    public function __construct(string $dataFolder) {
        $this->filePath = $dataFolder . "hub_location.json";
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
        $this->hubLocation = json_decode(file_get_contents($this->filePath), true);
    }

    public function setHubLocation(Position $position, string $worldName): void {
        $this->hubLocation = [
            "x" => $position->getX(),
            "y" => $position->getY(),
            "z" => $position->getZ(),
            "world" => $worldName
        ];
        $this->save();
    }

    public function getHubLocation(): ?Position {
        if (!isset($this->hubLocation["x"], $this->hubLocation["y"], $this->hubLocation["z"], $this->hubLocation["world"])) {
            return null;
        }

        $world = $this->getWorldByName($this->hubLocation["world"]);
        if ($world === null) {
            return null;
        }

        return new Position($this->hubLocation["x"], $this->hubLocation["y"], $this->hubLocation["z"], $world);
    }

    public function teleportPlayerToHub(Player $player): void {
        $hubLocation = $this->getHubLocation();
        if ($hubLocation === null) {
            $player->sendMessage("Hub location not found.");
            return;
        }

        $this->loadChunks($player, $hubLocation->getWorld(), $hubLocation->getX() >> 4, $hubLocation->getZ() >> 4);
        $player->teleport($hubLocation);
        $player->sendMessage("Teleported to the hub.");
    }

    private function loadChunks(Player $player, World $world, int $chunkX, int $chunkZ): void {
        $player->getWorld()->loadChunk($chunkX, $chunkZ);
        $player->getWorld()->loadChunk($chunkX + 1, $chunkZ);
        $player->getWorld()->loadChunk($chunkX, $chunkZ + 1);
        $player->getWorld()->loadChunk($chunkX + 1, $chunkZ + 1);
    }

    private function save(): void {
        file_put_contents($this->filePath, json_encode($this->hubLocation, JSON_PRETTY_PRINT));
    }

    private function getWorldByName(string $worldName): ?World {
        $server = Server::getInstance();
        return $server->getWorldManager()->getWorldByName($worldName);
    }
}
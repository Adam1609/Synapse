<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace synapse\command\defaults;

use synapse\command\Command;
use synapse\command\CommandSender;
use synapse\event\TranslationContainer;
use synapse\Player;
use synapse\utils\TextFormat;

class KickCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%synapse.command.kick.description",
			"%commands.kick.usage"
		);
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){

		if(count($args) === 0){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		$name = array_shift($args);
		$reason = trim(implode(" ", $args));

		if(($player = $sender->getServer()->getPlayer($name)) instanceof Player){
			$player->close($reason);
			if(strlen($reason) >= 1){
				$sender->sendMessage(new TranslationContainer("commands.kick.success.reason", [$player->getName(), $reason]));
			}else{
				$sender->sendMessage(new TranslationContainer("commands.kick.success", [$player->getName()]));
			}
		}else{
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
		}


		return true;
	}
}

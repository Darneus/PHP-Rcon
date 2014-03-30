<?php
require_once("games/engine/FrostbiteEngine.class.php");

/**
 * Battlefield 4
 *
 * @author      Jan Altensen (Stricted)
 * @copyright   2013-2014 Jan Altensen (Stricted)
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class BF4 extends FrostbiteEngine {
	/**
	 * get players from gameserver
	 *
	 * @return	array
	 */
	public function getPlayers () {
		$response = $this->encodeClientRequest('listPlayers all');
		$players = array();
		
		if ($response[0] == 'OK') {
			for ($i = 13; $i < count($response); $i += 10) {
				$player = array();
				$player['name'] = $response[$i];
				$player['guid'] = $response[$i+1];/* GUID is empty, because we are not logged in */
				$player['teamId'] = $response[$i+2];
				$player['squadId'] = $response[$i+3];
				$player['kills'] = $response[$i+4];
				$player['deaths'] = $response[$i+5];
				$player['score'] = $response[$i+6];
				$player['rank'] = $response[$i+7];
				$player['ping'] = $response[$i+8];
				$player['type'] = $response[$i+9];
					
				$players[] = $player;
			}
		}
		
		return $players;
	}
	
	/**
	 * get maxplayers from gameserver
	 *
	 * @return	integer
	 */
	public function getMaxPlayers () {
		$response = $this->encodeClientRequest('serverInfo');
		if ($response[0] == 'OK') {
			return $response[3];
		}
		else {
			return false;
		}
	}
	
	/**
	 * get player count from server
	 *
	 * @return	integer
	 */
	public function getCurrentPlayerCount () {
		$response = $this->encodeClientRequest('serverInfo');
		if ($response[0] == 'OK') {
			return $response[2];
		}
		else {
			return false;
		}
	}
	
	/**
	 * get current map from gameserver
	 *
	 * @return	string
	 */
	public function getCurrentMap () {
		$response = $this->encodeClientRequest('serverInfo');
		if ($response[0] == 'OK') {
			return $response[5];
		}
		else {
			return false;
		}
	}
	
	/**
	 * get current game mode from gameserver
	 *
	 * @return	string
	 */
	public function getCurrentMode () {
		$response = $this->encodeClientRequest('serverInfo');
		if ($response[0] == 'OK') {
			return $response[4];
		}
		else {
			return false;
		}
	}
	
	/**
	 * get server name from gameserver
	 *
	 * @return	string
	 */
	public function getServerName () {
		$response = $this->encodeClientRequest('serverInfo');
		if ($response[0] == 'OK') {
			return $response[1];
		}
		else {
			return false;
		}
	}
	
	/**
	 * translate map code to map name
	 *
	 * @param	string	$id
	 * @return	string
	 */
	public function getMapName ($id) {
		$maps = array(
				/* Default Maps */
				"MP_Abandoned" => "Zavod 311",
				"MP_Damage" => "Lancang Dam",
				"MP_Flooded" => "Flood Zone",
				"MP_Journey" => "Golmud Railway",
				"MP_Naval" => "Paracel Storm",
				"MP_Prison" => "Operation Locker",
				"MP_Resort" => "Hainan Resort",
				"MP_Siege" => "Siege of Shanghai",
				"MP_TheDish" => "Rogue Transmission",
				"MP_Tremors" => "Dawnbreaker",
				/* China Rising */
				"XP1_001" => "Silk Road",
				"XP1_002" => "Altai Range",
				"XP1_003" => "Guilin Peaks",
				"XP1_004" => "Dragon Pass",
				/* Second Assault */
				"XP0_Caspian" => "Caspian Border 2014",
				"XP0_Firestorm" => "Operation Firestorm 2014",
				"XP0_Metro" => "Operation Metro 2014",
				"XP0_Oman" => "Gulf of Oman 2014"
				);
		
		if (array_key_exists($id, $maps)) {
			return $maps[$id];
		}
		
		return $id;
	}
}

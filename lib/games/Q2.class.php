<?php
namespace phpRcon\games;
use phpRcon\games\engine\Quake2Engine;

/**
 * Quake 3
 *
 * @author      Jan Altensen (Stricted)
 * @copyright   2013-2014 Jan Altensen (Stricted)
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class Q2 extends Quake2Engine {
	/**
	 * get players from gameserver
	 *
	 * @return	array
	 */
	public function getPlayers () {
		if (empty($this->data2)) {
			$this->data2 = $this->command("\xFF\xFF\xFF\xFFstatus\x00");
		}

		$data = $this->data2;
		$players = array();
		for ($i=2; $i<=count($data); $i++) {
			if (!empty($data[$i])) {
				$tmp = explode(" ", $data[$i], 3);
				$player = array();
				preg_match('/"([\s\S]+)"/i', $tmp[2], $match);
				$player['name'] = $this->stripColors($match[1]);
				$player['score'] = $tmp[0];
				$player['ping'] = $tmp[1];
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
		$data = $this->getServerData();
		return $data['maxclients'];
	}
	
	/**
	 * get player count from server
	 *
	 * @return	integer
	 */
	public function getCurrentPlayerCount () {
		return count($this->getPlayers());
	}
	
	/**
	 * get current map from gameserver
	 *
	 * @return	string
	 */
	public function getCurrentMap () {
		$data = $this->getServerData();
		return $data['mapname'];
	}
	
	/**
	 * get current game mode from gameserver
	 *
	 * @return	string
	 */
	public function getCurrentMode () {
		$data = $this->getServerData();
		return $data['game'];
	}
	
	/**
	 * get server name from gameserver
	 *
	 * @return	string
	 */
	public function getServerName () {
		$data = $this->getServerData();
		return $this->stripColors($data['gamename']);
	}
}

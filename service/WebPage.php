<?php
namespace Campusapp\Service;

use Campusapp\DAO;
use Campusapp\Service\Entities\User;

/**
 * Modela una pàgina web
 */

class WebPage
{
	private $contents;
	
	public function __construct() {
		$this->contents = "";
	}
	
	public function getContents(): string {
	    return $this->contents;
	}
	
	public function setContents($contents) {
		$this->contents = $contents;
	}
	
	public function contentsFromFile(string $filename) {
	    $this->contents = file_get_contents($filename);
	}
	
	public function addUserInfo($username) {
		$dao = DAO::getInstance();
		$user = $dao->getByFilter("User", ["username" => $username])[0];
		$this->addNavUserInfo($user);
	}
	
	private function addNavUserInfo(User $user) {
		define("NAVUSER", '<span id="user"></span>');
		$userInfo = $user->getNom() . " " . $user->getCognoms();
		$this->contents = str_replace(NAVUSER, $userInfo, $this->contents);
	}
	
	public function show() {
		echo $this->contents;
	}
	
	public function addRequired() {
	    while ($pos = strpos($this->contents, "<?php require ")) {
	        $final = strpos($this->contents, " ?>");
	        $filename = substr($this->contents, $pos + strlen("<?php require ") + 1, $final - ($pos + strlen("<?php require ") + 2));
	        $file = file_get_contents(TPLDIR . $filename);
	        $this->contents = substr($this->contents, 0, $pos) . $file . substr($this->contents, $final + strlen(" ?>"));
	    }
	}
	
	public function insert(string $needle, string $insertion, int $pos=0) {
	    $index = strpos($this->contents, $needle, $pos);
	    if ($index) $this->contents = substr_replace($this->contents, $insertion, $index, 0);
	}
}
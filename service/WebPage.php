<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Staff;

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
	
	public function addUserInfo(string $email) {
	    $ss = new StaffService();
	    try {
	        $user = $ss->getMemberByEmail($email);
	        $this->addNavUserInfo($user);
	    } catch (\Exception $e) {
	        throw $e;
	    }
	}
	
	private function addNavUserInfo(Staff $user) {
		define("NAVUSER", '<span id="user"></span>');
		$userInfo = $user->getName() . " " . $user->getSurnames();
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
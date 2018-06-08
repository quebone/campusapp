<?php
use Campusapp\Service\UserService;

require 'init.php';

if (session_status() == PHP_SESSION_NONE) session_start();
unset($_SESSION["session"]);
unset($_SESSION["username"]);
unset($_SESSION["password"]);

if (isset($_POST["username"]) && isset($_POST["password"])) {
	$service = new UserService();
	if ($service->isRegistered($_POST["username"], $_POST["password"])) {
		$_SESSION["session"] = uniqid();
		$_SESSION["username"] = $_POST["username"];
		$_SESSION["password"] = sha1($_POST["password"]);
		header("Location: fitxes.php");
	} else {
		require TPLDIR . "login.html";
	}
} else {
	require TPLDIR . "login.html";
}
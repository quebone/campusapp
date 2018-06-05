<?php
if (session_status() == PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["session"])) {
	header("Location: login.php");
	die();
}

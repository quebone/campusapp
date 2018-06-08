<?php
use Campusapp\Presentation\Controller\LoginController;

if (session_status() == PHP_SESSION_NONE) session_start();

$lc = new LoginController();
try {
    $lc->isLogged();
} catch (Exception $e) {
    header("Location: index.php");
    die();
}

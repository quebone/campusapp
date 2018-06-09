<?php
use Campusapp\Presentation\Controller\AccreditationsController;

require_once 'init.php';

if (!isset($_GET) || !isset($_GET['ids'])) die();

$controller = new AccreditationsController();
$controller->printAccreditations($_GET);
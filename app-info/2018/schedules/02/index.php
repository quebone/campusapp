<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\WebInfoController;

$rootDir = '../../../../';
require_once $rootDir.'init.php';

// $_GET['lang'] = 'ca';
$page = new WebPage();
$controller = new WebInfoController($rootDir);
$data = $controller->getSchedule($_GET, __DIR__);
$data['lang'] = $_GET['lang'];
$template = new \Transphporm\Builder($rootDir.WEBTPLDIR.'schedule.html', $rootDir.WEBTPLDIR.'schedule.tss');
$page->setContents($template->output($data)->body);
$page->show();

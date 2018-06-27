<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\WebInfoController;

$rootDir = '../../../';
require_once $rootDir.'init.php';

$page = new WebPage();
$controller = new WebInfoController($rootDir);
$data['schedules'] = $controller->getCurrentSchedules($_GET);
$data['lang'] = 'ca';
$template = new \Transphporm\Builder($rootDir.WEBTPLDIR.'schedules.html', $rootDir.WEBTPLDIR.'schedules.tss');
$page->setContents($template->output($data)->body);
$page->show();

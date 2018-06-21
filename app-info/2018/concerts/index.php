<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\WebInfoController;

$rootDir = '../../../';
require_once $rootDir.'init.php';

// $_GET['lang'] = 'ca';
$page = new WebPage();
$controller = new WebInfoController($rootDir);
$data['concerts'] = $controller->getCurrentConcerts($_GET);
$template = new \Transphporm\Builder($rootDir.WEBTPLDIR.'concerts.html', $rootDir.WEBTPLDIR.'concerts.tss');
$page->setContents($template->output($data)->body);
$page->show();

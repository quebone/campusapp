<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\WebInfoController;

$rootDir = '../../../../';
require_once $rootDir.'init.php';

// $_GET['lang'] = 'ca';
$page = new WebPage();
$controller = new WebInfoController($rootDir);
$data = $controller->getConcert($_GET, __DIR__);
$template = new \Transphporm\Builder($rootDir.WEBTPLDIR.'concert.html', $rootDir.WEBTPLDIR.'concert.tss');
$page->setContents($template->output($data)->body);
$page->show();

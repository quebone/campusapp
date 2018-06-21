<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\WebInfoController;

$rootDir = '../../../';
require_once $rootDir.'init.php';

$page = new WebPage();
$controller = new WebInfoController($rootDir);
$data['workshops'] = $controller->getCurrentWorkshops($_GET);
$template = new \Transphporm\Builder($rootDir.WEBTPLDIR.'workshops.html', $rootDir.WEBTPLDIR.'workshops.tss');
$page->setContents($template->output($data)->body);
$page->show();

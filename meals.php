<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\MealsController;

require_once 'init.php';
// require_once 'sessions.php';

$mc = new MealsController();
$data = [];
$data['meals'] = $mc->getMealStatistics();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'meals.html', TPLDIR.'meals.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
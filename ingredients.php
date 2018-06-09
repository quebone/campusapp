<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\IngredientsController;

require_once 'init.php';
require_once 'sessions.php';

$mc = new IngredientsController();
$data = [];
$data['ingredients'] = $mc->getIngredients();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'ingredients.html', TPLDIR.'ingredients.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
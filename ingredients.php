<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\IngredientsController;
use Campusapp\Service\SystemService;

require_once 'init.php';
require_once 'sessions.php';

$ic = new IngredientsController();
$ss = new SystemService();

$data = [];
$data['ingredients'] = $ic->getIngredients();
$data['system'] = $ss->getSystem()->toArray();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'ingredients.html', TPLDIR.'ingredients.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
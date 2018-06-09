<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\RegistrationsController;

require_once 'init.php';
require_once 'sessions.php';

$rc = new RegistrationsController();
$data = [];
$data['registered'] = $rc->getRegistered();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'registrations.html', TPLDIR.'registrations.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
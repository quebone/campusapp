<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\AttendancesController;

require_once 'init.php';
require_once 'sessions.php';

$mc = new AttendancesController();
$data = [];
$data['attendants'] = $mc->getAttendants();
$data['members'] = $mc->getEgsMembers();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'attendances.html', TPLDIR.'attendances.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
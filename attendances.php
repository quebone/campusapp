<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\AttendancesController;

require_once 'init.php';
require_once 'sessions.php';

$rc = new AttendancesController();
$data = [];
$data['attendants'] = $rc->getAttendants();
$data['members'] = $rc->getEgsMembers();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'attendances.html', TPLDIR.'attendances.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
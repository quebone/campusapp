<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\AttendancesController;

require_once 'init.php';
require_once 'sessions.php';

$ss = new AttendancesController();
$data = [];
$data['attendants'] = $ss->getAttendants();
$data['members'] = $ss->getEgsMembers();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'attendances.html', TPLDIR.'attendances.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
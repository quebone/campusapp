<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\AttendancesController;

require_once 'init.php';

$ac = new AttendancesController();
$data = [];
$data['attendants'] = $ac->getAttendants();
$data['members'] = $ac->getEgsMembers();

$template = new \Transphporm\Builder(TPLDIR.'attendances.html', TPLDIR.'attendances.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
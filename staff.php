<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\StaffController;

require_once 'init.php';
require_once 'sessions.php';

$mc = new StaffController();
$data = [];
$data['staff'] = $mc->getStaff();
$data['members'] = $mc->getEgsMembers();
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'staff.html', TPLDIR.'staff.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
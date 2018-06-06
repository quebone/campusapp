<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\StaffController;

require_once 'init.php';

$ac = new StaffController();
$data = [];
$data['staff'] = $ac->getStaff();
$data['members'] = $ac->getEgsMembers();

$template = new \Transphporm\Builder(TPLDIR.'staff.html', TPLDIR.'staff.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
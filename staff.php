<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\StaffController;

require_once 'init.php';

$sc = new StaffController();
$data = [];
$data['staff'] = $sc->getStaff();
$data['members'] = $sc->getEgsMembers();

$template = new \Transphporm\Builder(TPLDIR.'staff.html', TPLDIR.'staff.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
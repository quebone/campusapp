<?php
use Campusapp\Service\WebPage;
use Campusapp\Service\SystemService;

require_once 'init.php';

$ss = new SystemService();
$data['system'] = $ss->getSystem()->toArray();
$template = new \Transphporm\Builder(TPLDIR.'creps.html', TPLDIR.'creps.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
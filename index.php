<?php
use Campusapp\Service\WebPage;

require_once 'init.php';
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'index.html', TPLDIR.'index.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();

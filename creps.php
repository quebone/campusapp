<?php
use Campusapp\Service\WebPage;
use Campusapp\Service\SystemService;

require_once 'init.php';

if (session_status() == PHP_SESSION_NONE) session_start();

$ss = new SystemService();
$data['system'] = $ss->getSystem()->toArray();
$data['system']['logged'] = FALSE;
$data['system']['incorrectPassword'] = FALSE;

// $_POST['password'] = 'creps2018';
if (isset($_POST) && isset($_POST['password'])) {
    if (!strcmp(urldecode($_POST['password']), $ss->getSystem()->getCrepsManagerPassword())) {
        session_create_id();
        $data['system']['logged'] = TRUE;
    } else {
        $data['system']['incorrectPassword'] = TRUE;
    }
}

$template = new \Transphporm\Builder(TPLDIR.'creps.html', TPLDIR.'creps.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->show();
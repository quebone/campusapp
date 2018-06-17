<?php
use Campusapp\Service\WebPage;
use Campusapp\Presentation\Controller\NotificationsController;

require_once 'init.php';
require_once 'sessions.php';

$nc = new NotificationsController();
$data = [];
$data['notifications'] = $nc->getNotifications();
$data['groups'] = NOTIFICATION_GROUPS;
require_once 'navigation.php';

$template = new \Transphporm\Builder(TPLDIR.'notifications.html', TPLDIR.'notifications.tss');
$page = new WebPage();
$page->setContents($template->output($data)->body);
$page->addUserInfo($_SESSION["email"]);
$page->show();
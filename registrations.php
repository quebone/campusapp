<?php
use Campusapp\Presentation\Controller\RegistrationsController;
use Campusapp\Service\WebPage;

require_once 'init.php';

$page = new WebPage();
if (isset($_POST) && isset($_POST['email']) && isset($_POST['dni']) && isset($_POST['option'])) {
    $rc = new RegistrationsController();
    switch ($_POST['option']) {
        case 0: //get
            $data = $rc->getRegistration($_POST);
            $data['user']['dni'] = $_POST['dni'];
            $data['disabled'] = TRUE;
            $template = new \Transphporm\Builder(TPLDIR.'registration-data.html', TPLDIR.'registration-data.tss');
            $page->setContents($template->output($data)->body);
            break;
        case 1:  //save
            $rc->addRegistration($_POST);
            $page->contentsFromFile(TPLDIR . 'registration-ok.html');
            break;
        case 2:  //delete
    }
} else {
    $page->contentsFromFile(TPLDIR . 'registration.html');
}
$page->show();

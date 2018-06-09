<?php
use Campusapp\Presentation\Controller\RegistrationController;
use Campusapp\Service\WebPage;

require_once 'init.php';

$page = new WebPage();
if (isset($_POST) && isset($_POST['email']) && isset($_POST['dni']) && isset($_POST['option'])) {
    $mc = new RegistrationController();
    switch ($_POST['option']) {
        case 0: //get
            $data = $mc->getRegistration($_POST);
            $data['user']['dni'] = $_POST['dni'];
            $data['disabled'] = TRUE;
            require_once 'navigation.php';
            $template = new \Transphporm\Builder(TPLDIR.'registration-data.html', TPLDIR.'registration-data.tss');
            $page->setContents($template->output($data)->body);
            break;
        case 1:  //save
            $mc->addRegistration($_POST);
            require_once 'navigation.php';
            $template = new \Transphporm\Builder(TPLDIR.'registration-ok.html', TPLDIR.'registration-ok.tss');
            $page->setContents($template->output($data)->body);
            break;
        case 2:  //delete
    }
} else {
    require_once 'navigation.php';
    $template = new \Transphporm\Builder(TPLDIR.'registration.html', TPLDIR.'registration.tss');
    $page->setContents($template->output($data)->body);
}
$page->show();

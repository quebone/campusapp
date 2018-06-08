<?php
use Campusapp\Service\StaffService;
use Campusapp\Presentation\Model\StaffModel;

if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($data)) $data = [];
if (isset($_SESSION["session"]) && isset($_SESSION['email'])) {
    $ss = new StaffService();
    $user = $ss->getMemberByEmail($_SESSION['email']);
    $sm = new StaffModel();
    $data['logged'] = TRUE;
    $data['loggedUser'] = $sm->getStaffData($user);
} else {
    $data['logged'] = FALSE;
}

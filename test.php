<?php

use Campusapp\Service\AccreditationsService;
use Campusapp\Service\Entities\User;

require_once 'init.php';

define('DEBUG', true);

function toArgs($input): array {
    $data = [];
    $fields = explode("&", $input);
    foreach ($fields as $field) {
        $arr = explode("=", $field);
        $data[$arr[0]] = $arr[1];
    }
    return $data;
}

function test01() {
    $_POST = toArgs('name=Alba&surnames=Muntada Prat&email=albeta70@hotmail.es&role=3&accommodation=0&diet=0&thursdayDinner=true&fridayLunch=false&fridayDinner=true&saturdayLunch=false&saturdayDinner=false&sundayLunch=false&function=addAttendance&caller=Attendances');
    require_once 'AjaxController.php';
}

function test02() {
    $as = new AccreditationsService();
    $user = new User();
    $user->setName('Carles');
    $user->setSurnames('Canellas');
    $user->setEmail('carlescanellas@hotmail.com');
    $as->makeAccreditation($user);
}

test01();

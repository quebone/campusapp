<?php

require_once 'init.php';
// require_once 'presentation/controller/Controller.php';

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
    $_POST = toArgs('name=Gemma&surnames=Solà Serra&email=gemmas23@gmail.com&accommodation=0&diet=0&thursdayDinner=false&fridayLunch=false&fridayDinner=false&saturdayLunch=false&saturdayDinner=false&sundayLunch=false&function=addAttendance&caller=Attendances');
    require_once 'AjaxController.php';
}

test01();

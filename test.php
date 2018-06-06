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
    $_POST = toArgs('email=carlescanellas%40hotmail.com&dni=39352088P&option=0&function=getRegistration&caller=Registrations');
    require_once 'AjaxController.php';
}

test01();

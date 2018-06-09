<?php


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
//     $_POST = toArgs('email=carlescanella@hotmail.com&function=register&caller=Meals');
    $_POST = toArgs('function=existsCurrentMeal&caller=Meals');
    require_once 'AjaxController.php';
}

test01();

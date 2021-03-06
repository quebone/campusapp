<?php

use Campusapp\Service\Entities\WebSchedule;

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

function test01(string $post) {
    $_POST = toArgs($post);
    require_once 'AjaxController.php';
}

function test02() {
    $xmlFile = WEBDIR.'2018/schedules/01/ca/text.txt';
    $schedule = new WebSchedule(WEBDIR.'2018/schedules/01/', 'ca');
    print_r($schedule->toArray()['activities']);
}

test01("function=getMostOrderedIngredients&caller=Ingredients");



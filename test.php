<?php


use Campusapp\Presentation\Controller\StaffController;

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
    $_POST = toArgs('regtoken=d0cb3pywuSw:APA91bF3XVUlbM-SJCYwZxyqED_XHMKv7V9TZUP9gTW7EL4Vmdj6ePS8xFxi-qu8cA4mpjZclFvesSoCF56ExMOVJITjcdKZkW8GG7RJQhbtKqCK06yBDs2Rs7IpLD_1uR5hxxs6Vo4B&ingredients=[Codony,Nata]&function=createOrder&caller=Creps');
//     $_POST = toArgs('email=carlescanellas@hotmail.com&function=deleteRegistration&caller=Registration');
    require_once 'AjaxController.php';
}

function test02() {
    $sc = new StaffController();
    $sc->addStaff(['name'=>"nom", 'surnames'=>"cognoms", 'email'=>'email', 'password'=>"password"]);
}

test01();

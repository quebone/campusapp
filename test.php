<?php


use Campusapp\Service\FirebaseService;

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
//     $_POST = toArgs('regToken=dA-s-NC7KdU:APA91bEn0typeDUTNcpNeI8opWh3ogcLPrcEEGbRMJ-OLmP8o_jagB59WsC1WN0LvelLUNFooK32_2A3pYeUWLdnfqrpPCRnYwBm9mBDR-50RE7T_hRdLWmcvvN8aAEEL3wQJdEsVBGy&ingredients=Formatge roquefort,Llet condensada,Melmelada de maduixa,Nous&function=createOrder&caller=Creps');
    $_POST = toArgs('email=carlescanellas@hotmail.com&function=deleteRegistration&caller=Registration');
    require_once 'AjaxController.php';
}

function test02() {
    $fbs = new FirebaseService();
    $fbs->setToken('dA-s-NC7KdU:APA91bE_fwl-Nv_z4YHY_jjDznffRYnGHVAu7eMtNNgviy9Tby-jBIwxIklgvdwNoeUTk-oFagRRHJuzSL28MuY2HdaX5_gmw-EZQ3BPmH_jQUgEhtYlnr1UQcSa-AwdAsox-4RyAilZ');
    $fbs->setTitle("titol");
    $fbs->setMessage("missatge");
    $fbs->send();
}

test01();

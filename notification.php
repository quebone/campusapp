<?php
use Campusapp\Service\FirebaseService;

require_once 'init.php';

$fbService = new FirebaseService();

$title = "El crep amb número 1 està a punt";
$message = "Porta el tiquet al taulell i podràs recollir-lo";

$fbService->setTitle($title);
$fbService->setMessage($message);

$firebase_token = 'dA-s-NC7KdU:APA91bE_fwl-Nv_z4YHY_jjDznffRYnGHVAu7eMtNNgviy9Tby-jBIwxIklgvdwNoeUTk-oFagRRHJuzSL28MuY2HdaX5_gmw-EZQ3BPmH_jQUgEhtYlnr1UQcSa-AwdAsox-4RyAilZ';
$firebase_api = 'AAAA9Wj-1pQ:APA91bHyV2PjSk58KwhCd1zZnA7gE2CROk9lsUvZHilqR--W0wpyDnps-FWNJBdTV8vjM4p4Ae7_qknaPRuizka2t4hAMQOwJUxdwcVU8NfVRubTAtD1_pS9tpM0U-0gWZHfOlKNdqE1';

$requestData = $fbService->getNotification();

$fields = array(
    'to' => $firebase_token,
    'data' => $requestData,
    'notification' => [
        'title' => "El crep amb número 1 està a punt",
        'body' => 'Porta el tiquet al taulell i podràs recollir-lo',
        'sound' => 'default',
    ],
    'priority' => 10,
);

// Set POST variables
$url = 'https://fcm.googleapis.com/fcm/send';

$headers = array(
    'Authorization: key=' . $firebase_api,
    'Content-Type: application/json'
);

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disabling SSL Certificate support temporarily
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
$result = curl_exec($ch);
if($result === FALSE){
    die('Curl failed: ' . curl_error($ch));
}

// Close connection
curl_close($ch);

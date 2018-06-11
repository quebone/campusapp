<?php
namespace Campusapp\Service;

class FirebaseService extends Service
{
    private $api;
    private $token;
    private $title;
    private $body;
    private $message;
    private $image_url;
    private $action;
    private $action_destination;
    private $sound;
    private $data;
    private $priority;
    
    public function __construct() {
        parent::__construct();
        $this->api = 'AAAA9Wj-1pQ:APA91bHyV2PjSk58KwhCd1zZnA7gE2CROk9lsUvZHilqR--W0wpyDnps-FWNJBdTV8vjM4p4Ae7_qknaPRuizka2t4hAMQOwJUxdwcVU8NfVRubTAtD1_pS9tpM0U-0gWZHfOlKNdqE1';
        $this->sound = 'default';
    }

    public function setApi(string $api) {
        $this->api = $api;
    }
    
    public function setToken(string $token) {
        $this->token = $token;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    
    public function setBody(string $body) {
        $this->body = $body;
    }
    
    public function setMessage($message){
        $this->message = $message;
    }
    
    public function setImage($imageUrl){
        $this->image_url = $imageUrl;
    }
    
    public function setAction($action){
        $this->action = $action;
    }
    
    public function setActionDestination($actionDestination){
        $this->action_destination = $actionDestination;
    }
    
    public function setPayload($data){
        $this->data = $data;
    }
    
    public function getNotification(): array {
        return [
            'title'=> $this->title,
            'body' => $this->body,
            'sound' => $this->sound,
        ];
    }
    
    public function getData(): array {
        return [
            'title'=> $this->title,
            'message' => $this->message,
            'image' => $this->image_url,
            'action' => $this->action,
            'action_destination' => $this->action_destination,
        ];
    }
    
    public function send() {
        $fields = array(
            'to' => $this->token,
            'data' => $this->getData(),
            'notification' => $this->getNotification(),
            'priority' => $this->priority,
        );
        
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $headers = array(
            'Authorization: key=' . $this->api,
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
    }
}
<?php
namespace Campusapp\Exceptions;

class FirebaseException extends \Exception {
    public function __construct() {
        $this->message = "Could not send notification";
    }
}
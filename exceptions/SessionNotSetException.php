<?php
namespace Campusapp\Exceptions;

class SessionNotSetException extends \Exception {
    public function __construct() {
        $this->message = "Session not set";
    }
}
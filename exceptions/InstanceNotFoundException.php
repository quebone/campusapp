<?php
namespace Campusapp\Exceptions;

class InstanceNotFoundException extends \Exception {
    public function __construct() {
        $this->message = "Instance not found";
    }
}
<?php
namespace Campusapp\Exceptions;

class UserHasRegistrationException extends \Exception {
    public function __construct() {
        $this->message = "This user has a registration";
    }
}
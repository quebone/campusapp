<?php
namespace Campusapp\Exceptions;

class InvalidPasswordException extends \Exception {
    public function __construct() {
        $this->message = "Mida de password incorrecta";
    }
}
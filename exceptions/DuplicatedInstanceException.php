<?php
namespace Campusapp\Exceptions;

class DuplicatedInstanceException extends \Exception {
    public function __construct() {
        $this->message = "Instance already exists";
    }
}
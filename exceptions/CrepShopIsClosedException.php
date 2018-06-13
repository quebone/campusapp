<?php
namespace Campusapp\Exceptions;

class CrepShopIsClosedException extends \Exception {
    public function __construct() {
        $this->message = "La venda telemàtica de creps està tancada";
    }
}
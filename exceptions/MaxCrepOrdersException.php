<?php
namespace Campusapp\Exceptions;

class MaxCrepOrdersException extends \Exception {
    public function __construct() {
        $this->message = "No pots fer més comandes, encara en tens pendents de recollir\nPassa per la parada a demanar informació";
    }
}
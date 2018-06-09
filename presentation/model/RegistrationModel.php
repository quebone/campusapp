<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\Entities\Registration;

class RegistrationModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
 
    public function getRegistrationData(Registration $registration): array {
        $data = $registration->toArray();
        return $data;
    }
}
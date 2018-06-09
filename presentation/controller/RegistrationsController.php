<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\RegistrationsService;
use Campusapp\Presentation\Model\UserModel;

class RegistrationsController extends Controller
{
    private $rs;
    
    public function __construct() {
        parent::__construct();
        $this->rs = new RegistrationsService();
    }
    
    public function getRegistered(): array {
        try {
            $registered = $this->rs->getCurrentRegistered();
            $um = new UserModel();
            return $um->getAllUsersData($registered);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
}
    
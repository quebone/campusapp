<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\LoginService;
use Campusapp\Presentation\Model\StaffModel;
use Campusapp\Exceptions\SessionNotSetException;

class LoginController extends Controller
{
    private $ls;
    
    public function __construct() {
        parent::__construct();
        $this->ls = new LoginService();
    }
    
    public function isLogged(): bool {
        if ($this->ls->isLogged()) return TRUE;
        throw new SessionNotSetException();
    }
    
    public function login(array $post): array {
        $post = $this->decodeUrl($post);
        try {
            $staff = $this->ls->loginStaff($post['email'], $post['password']);
            $this->ls->setSession($post['email'], $staff->getName(), $staff->getSurnames());
            $sm = new StaffModel();
            return $sm->getStaffData($staff);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function logout(): bool {
        $this->ls->unsetSession();
        return TRUE;
    }
}
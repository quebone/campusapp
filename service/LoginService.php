<?php
namespace Campusapp\Service;

use Campusapp\Exceptions\InstanceNotFoundException;
use Campusapp\Service\Entities\Staff;

class LoginService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function loginStaff(string $email, string $password): Staff {
        try {
            $staff = $this->dao->getByFilter("Staff", ['email'=>$email]);
            if (count($staff) > 0) {
                if (password_verify($password, $staff[0]->getPassword())) {
                    return $staff[0];
                }
            }
            throw new InstanceNotFoundException();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function setSession(string $email, string $name, string $surnames) {
        $_SESSION["session"] = uniqid();
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $name . " " . $surnames;
    }
    
    public function unsetSession() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        unset($_SESSION['session']);
    }
    
    public function isLogged(): bool {
        return (isset($_SESSION['session']) && isset($_SESSION['email'])
            && isset($_SESSION['username'])); 
    }
}
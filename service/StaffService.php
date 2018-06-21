<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Staff;
use Campusapp\Exceptions\InstanceNotFoundException;

class StaffService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getStaff(): array {
        try {
            return $this->dao->getByFilter("Staff");
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getMember(int $id): Staff {
        try {
            return $this->dao->getById("Staff", $id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getMemberByEmail(string $email): Staff {
        try {
            $result = $this->dao->getByFilter("Staff", ['email'=>$email]);
            if (count($result) > 0) return $result[0];
            throw new InstanceNotFoundException();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function getMemberByEmailAndPassword(string $email, string $password): Staff {
        try {
            $member = $this->getMemberByEmail($email);
            if (password_verify($password, $member->getPassword())) return $member;
            throw new InstanceNotFoundException();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addStaff(string $name, string $surnames, string $email, string $password): Staff {
        try {
            $members = $this->dao->getByFilter("Staff", ['email'=>$email]);
            if (count($members) == 0) {
                $staff = new Staff();
                $this->dao->persist($staff);
            } else {
                $staff = $members[0];
            }
            $this->updateStaff($staff, $name, $surnames, $email, $password);
            return $staff;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function updateStaff(Staff $staff, string $name, string $surnames, string $email, string $password) {
        $staff->setName($name);
        $staff->setSurnames($surnames);
        $staff->setEmail($email);
        if (strlen($password) > 0) $staff->setPassword(password_hash($password, PASSWORD_BCRYPT));
        try {
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteStaff(int $id) {
        try {
            $staff = $this->dao->getById("Staff", $id);
            if (isset($_SESSION['email']) && !strcmp($staff->getEmail(), $_SESSION['email'])) {
                throw new \Exception('No et pots eliminar tu mateix');
            }
            foreach ($this->dao->getByFilter("Notification", ['staff'=>$staff]) as $notification) {
                $this->dao->remove($notification);
            }
            $this->dao->remove($staff);
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
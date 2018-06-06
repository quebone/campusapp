<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Staff;

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
            $this->dao->remove($staff);
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
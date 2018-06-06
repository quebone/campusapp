<?php
namespace Campusapp\Service;

use Campusapp\Exceptions\InstanceNotFoundException;
use Campusapp\Service\Entities\User;

class UserService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getJoomlaActiveUsers(): array {
        $db = \JFactory::getDBO();
        $query = "SELECT * FROM #__users WHERE block=0 ORDER BY name" ;
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        return $rows;
    }
    
    public function removeAdministratorFromJoomlaActiveUsers(array $members): array {
        foreach ($members as $key => $member) {
            if (!strcmp(ADMIN_EGS_EMAIL, $member['email'])) {
                unset($members[$key]);
            }
        }
        return $members;
    }
    
    public function getJoomlaUserByEmail(string $email): array {
        $db = \JFactory::getDBO();
        $query = "SELECT * FROM #__users WHERE email='$email' AND block=0" ;
        $db->setQuery($query);
        $row = $db->loadAssoc();
        if ($row != NULL) return $row;
        throw new InstanceNotFoundException();
    }

    public function getJoomlaUserById(int $id): array {
        $db = \JFactory::getDBO();
        $query = "SELECT * FROM #__users WHERE id=$id AND block=0" ;
        $db->setQuery($query);
        $row = $db->loadAssoc();
        if ($row != NULL) return $row;
        throw new InstanceNotFoundException();
    }
    
    public function getUserById(int $id): User {
        try {
            return $this->dao->getById("User", $id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getUserByEmail(string $email): User {
        try {
            $users = $this->dao->getByFilter("User", ['email'=>$email]);
            if (count($users) > 0) return $users[0];
            throw new InstanceNotFoundException;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
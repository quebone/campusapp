<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\UserService;
use Campusapp\Presentation\Model\UserModel;

class UserController extends Controller
{
    private $us;
    private $um;
    
    public function __construct() {
        parent::__construct();
        $this->us = new UserService();
        $this->um = new UserModel();
    }
    
    public function getEgsMembers(): array {
        $egsMembers = $this->us->getJoomlaActiveUsers();
        $egsMembers = $this->us->removeAdministratorFromJoomlaActiveUsers($egsMembers);
        $egsData = $this->um->getAllEgsBasicData($egsMembers);
        return $this->um->addEgsNullMember($egsData);
    }

    public function getEgsData(array $post): array {
        try {
            $joomUser = $this->us->getJoomlaUserById(intval($post['id']));
            return $this->um->getEgsBasicData($joomUser);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
<?php
namespace Campusapp\Service;

class UserService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getJoomlaActiveUsers(): array {
        $db = \JFactory::getDBO();
        $query = "SELECT * FROM #__users WHERE block=0" ;
        $db->setQuery($query);
        $rows = $db->loadAssocList();
        return $rows;
    }
}
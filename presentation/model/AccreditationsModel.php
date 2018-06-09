<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\AccreditationsService;

class AccreditationsModel extends Model
{
    protected $as;
    
    public function __construct() {
        $this->as = new AccreditationsService();
    }
}
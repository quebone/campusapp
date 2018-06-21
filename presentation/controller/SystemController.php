<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\SystemService;

class SystemController extends Controller
{
    private $ss;
    
    public function __construct() {
        parent::__construct();
        $this->ss = new SystemService();
    }
    
    public function setCrepsEnabled(array $post): bool {
        $post = $this->normalize($post);
        return $this->ss->setCrepsEnabled($post['crepsEnabled']);
    }
    
    public function setCrepsManagerEnabled(array $post): bool {
        $post = $this->normalize($post);
        return $this->ss->setCrepsManagerEnabled($post['crepsManagerEnabled']);
    }
    
    public function setCrepsManagerPassword(array $post): bool {
        $post = $this->normalize($post);
        try {
            $this->ss->setCrepsManagerPassword($post['password']);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function setMaxPendingCreps(array $post): bool {
        $post = $this->normalize($post);
        return $this->ss->setMaxPendingCreps($post['maxPendingCreps']);
    }
}
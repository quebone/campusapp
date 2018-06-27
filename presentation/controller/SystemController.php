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
         $this->ss->setCrepsEnabled($post['crepsEnabled']);
         return TRUE;
    }
    
    public function setCrepsManagerEnabled(array $post): bool {
        $post = $this->normalize($post);
        $this->ss->setCrepsManagerEnabled($post['crepsManagerEnabled']);
        return TRUE;
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
        $this->ss->setMaxPendingCreps($post['maxPendingCreps']);
        return TRUE;
    }
    
    public function saveAllSettings(array $post): bool {
        $post = $this->normalize($post);
        if (isset($post['crepsEnabled'])) $this->setCrepsEnabled($post);
        if (isset($post['crepsManagerEnabled'])) $this->setCrepsManagerEnabled($post);
        if (isset($post['maxPendingCreps'])) $this->setMaxPendingCreps($post);
        if (isset($post['password'])) {
            try {
                $this->setCrepsManagerPassword($post);
            } catch (\Exception $e) {
            } finally {
                return TRUE;
            }
        }
    }
    
    public function getSystem(): array {
        return $this->ss->getSystem()->toArray();
    }
}
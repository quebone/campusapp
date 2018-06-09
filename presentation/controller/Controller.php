<?php
namespace Campusapp\Presentation\Controller;

class Controller
{
    public function __construct() {
        
    }
    
    protected function decodeUrl(array $post): array {
        foreach ($post as $key => $value) {
            $post[$key] = urldecode($value);
        }
        return $post;
    }
    
    protected function normalize(array $post): array {
        $post = $this->decodeUrl($post);
        foreach ($post as $key => $value) {
            if (!strcmp($value, 'true')) {
                $post[$key] = TRUE;
            } elseif (!strcmp($value, 'false')) {
                $post[$key] = FALSE;
            } elseif (is_numeric($value)) {
                $post[$key] = intval($value);
            }
        }
        return $post;
    }
    
    public function isLogged(): bool {
        $lc = new LoginController();
        try {
            return $lc->isLogged();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function login(array $post): array {
        $lc = new LoginController();
        try {
            return $lc->login($post);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function logout(): bool {
        $lc = new LoginController();
        return $lc->logout();
    }
    
    public function printAccreditations(array $post): bool {
        $ac = new AccreditationsController();
        return $ac->printAccreditations($post);
    }
}
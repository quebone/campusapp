<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\AccreditationsService;
use Campusapp\Service\UserService;
use Campusapp\Presentation\View\AccreditationsPdfView;

class AccreditationsController extends Controller
{
    private $as;
    
    public function __construct() {
        parent::__construct();
        $this->as = new AccreditationsService();
    }
    
    public function makeAccreditation(array $post): bool {
        $this->normalize($post);
        $us = new UserService();
        try {
            $user = $us->getUserById($post['id']);
            $this->as->makeAccreditation($user);
        } catch (\Exception $e) {
        }
        return TRUE;
    }
    
    public function printAccreditations(array $post): bool {
        $users = [];
        $us = new UserService();
        $ids = explode(",", $post['ids']);
        foreach ($ids as $id) {
            $users[] = $us->getUserById(intval($id));
        }
        try {
            $pdfView = new AccreditationsPdfView($users);
            $pdfView->getPdf();
        } catch (\Exception $e) {
            throw $e;
        }
        return TRUE;
    }
}
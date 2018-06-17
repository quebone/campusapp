<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\NotificationsService;
use Campusapp\Presentation\Model\NotificationsModel;

class NotificationsController extends Controller
{
    private $nm;
    private $ns;
    
    public function __construct() {
        parent::__construct();
        $this->nm = new NotificationsModel();
        $this->ns = new NotificationsService();
    }
    
    public function getNotifications(): array {
        try {
            return $this->nm->getNotificationsData();
        } catch (\Exception $e) {
            throw $e;
        }
    }
 
    public function addNotification(array $post): array {
        $post = $this->normalize($post);
        try {
            $notification = $this->ns->addNotification($post['id'], $post['title'], $post['body'], $post['message'], $post['group']);
            return $this->ns->sendNotification($notification->getId(), $post['group']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function sendNotification($post): array {
        try {
            return $this->ns->sendNotification(intval($post['id']), $post['group']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteNotification($post): bool {
        try {
            return $this->ns->deleteNotification(intval($post['id']));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
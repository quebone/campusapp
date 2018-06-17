<?php
namespace Campusapp\Presentation\Model;

use Campusapp\Service\NotificationsService;
use Campusapp\Service\Entities\Notification;

class NotificationsModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getNotificationsData(): array {
        $ns = new NotificationsService();
        try {
            $notifications = $ns->getNotifications();
        } catch (\Exception $e) {
            throw $e;
        }
        $data = [];
        foreach ($notifications as $notification) {
            $data[] = $this->getNotificationData($notification);
        }
        return $data;
    }
    
    public function getNotificationData(Notification $notification): array {
        $data = $notification->toArray();
        $data['groupName'] = NOTIFICATION_GROUPS[$notification->getRoleGroup()]['name'];
        $data['staff'] = $notification->getStaff()->getEmail();
        return $data;
    }
}
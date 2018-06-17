<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\Notification;

class NotificationsService extends Service
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getNotifications(): array {
        try {
            return $this->dao->getByFilter("Notification", [], ['date' => 'DESC']);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addNotification(int $staffId, string $title, string $body, string $message, int $group): Notification {
        try {
            $staff = $this->dao->getById("Staff", $staffId);
            $notification = new Notification();
            $notification->setTitle($title);
            $notification->setBody($body);
            $notification->setMessage($message);
            $notification->setStaff($staff);
            $notification->setRoleGroup($group);
            $this->dao->persist($notification);
            $this->dao->flush();
            return $notification;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function sendNotification(int $id, int $group): array {
        try {
            $notification = $this->dao->getById("Notification", $id);
            $as = new AttendancesService();
            $attendances = $this->dao->getByFilter("Attendance");
        } catch (\Exception $e) {
            throw $e;
        }
        $users = [];
        $roles = NOTIFICATION_GROUPS[$group]['roles'];
        foreach ($attendances as $attendance) {
            if ($as->isCurrent($attendance)) {
                if (!in_array($attendance->getUser(), $users) && in_array($attendance->getRole(), $roles)) $users[] = $attendance->getUser();
            }
        }
        $sent = 0;
        $failed = 0;
        foreach ($users as $user) {
            if (strlen($user->getRegtoken()) > 0) {
                $fbs = new FirebaseService();
                $fbs->setToken($user->getRegtoken());
                $fbs->setTitle($notification->getTitle());
                $fbs->setBody($notification->getBody());
                $fbs->setMessage($notification->getMessage());
                try {
                    $fbs->send();
                    $sent++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }
        }
        $notification->setSent($sent);
        $notification->setFailed($failed);
        try {
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
        return ['sent'=>$sent, 'failed'=>$failed];
    }
    
    public function deleteNotification(int $id): bool {
        try {
            $notification = $this->dao->getById("Notification", $id);
            $this->dao->remove($notification);
            $this->dao->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
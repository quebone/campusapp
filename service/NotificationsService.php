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
            return $this->dao->getByFilter("Notification");
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function addNotification(int $staffId, string $title, string $body, string $message, array $roles): Notification {
        try {
            $staff = $this->dao->getById("Staff", $staffId);
            $notification = new Notification();
            $notification->setTitle($title);
            $notification->setBody($body);
            $notification->setMessage($message);
            $notification->setStaff($staff);
            $roleInstances = $this->dao->getByFilter("Role");
            foreach ($roleInstances as $roleInstance) {
                if (in_array($roleInstance->getId(), $roles)) {
                    $notification->addRole($roleInstance);
                }
            }
            $this->dao->persist($notification);
            $this->dao->flush();
            return $notification;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function sendNotification(int $id, array $roles): array {
        try {
            $notification = $this->dao->getById("Notification", $id);
            $users = [];
            $as = new AttendancesService();
            $attendances = $this->dao->getByFilter("Attendance");
        } catch (\Exception $e) {
            throw $e;
        }
        foreach ($attendances as $attendance) {
            if ($as->isCurrent($attendance)) {
                if (!in_array($attendance->getUser(), $users)) $users[] = $attendance->getUser();
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
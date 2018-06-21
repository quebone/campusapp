<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela un administrador
 *
 * @Entity @Table(name="staff")
 */

class Staff extends RegisteredPerson implements IEntity
{
    /** @Column(type="string", length=255, nullable=true) **/
    private $password;
    /** @Column(type="integer") **/
    private $role;
    /** OneToMany target=Notification, mappedBy=staff, cascade={"all"} **/
    private $notifications;
    
    public function __construct() {
        parent::__construct();
        $this->password = password_hash(DEFAULT_PASSWORD, PASSWORD_BCRYPT);
        $this->role = ADMINISTRATOR;
        $this->notifications = new ArrayCollection();
    }
    
    public function getPassword(): ?string {
        return $this->password;
    }
    
    public function setPassword(?string $password) {
        $this->password = $password;
    }
    
    public function getRole(): int {
        return $this->role;
    }
    
    public function setRole(int $role) {
        $this->role = $role;
    }
    
    public function getNotifications(): ?Selectable {
        return $this->notifications;
    }
    
    public function setNotifications(Selectable $notifications) {
        $this->notifications = $notifications;
    }
    
    public function addNotification(Notification $notification): bool {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            return TRUE;
        }
        return FALSE;
    }
    
    public function removeNotification(Notification $notification): bool {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            return TRUE;
        }
        return FALSE;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surnames' => $this->surnames,
            'email' => $this->email,
            'role' => $this->role,
            'regtoken' => $this->regtoken,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this);
    }
}
<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela una notificació
 *
 * @Entity @Table(name="notifications")
 */

class Notification implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string", length=40) **/
    private $title;
    /** @Column(type="string", length=255) **/
    private $body;
    /** @Column(type="string", length=255) **/
    private $message;
    /** @Column(type="date") **/
    private $date;
    /** ManyToMany target="Role" **/
    private $roles;
    /** OneToOne target="Staff" **/
    private $staff;
    
    public function __construct() {
        $this->title = "";
        $this->body = "";
        $this->message = "";
        $this->date = new \DateTime();
        $this->roles = new ArrayCollection();
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getTitle(): string {
        return $this->title;
    }
    
    public function setTitle(string $title) {
        $this->title = $title;
    }
    
    public function getBody(): string {
        return $this->body;
    }
    
    public function setBody(string $body) {
        $this->body = $body;
    }
    
    public function getMessage(): string {
        return $this->message;
    }
    
    public function setMessage(string $message) {
        $this->message = $message;
    }
    
    public function getDate(): \DateTime {
        return $this->date;
    }
    
    public function setdate(\DateTime $date) {
        $this->date = $date;
    }
    
    public function getRoles(): Selectable {
        return $this->roles;
    }
    
    public function setRoles(Selectable $roles) {
        $this->roles = $roles;
    }
    
    public function addRole(Role $role): bool {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            return TRUE;
        }
        return FALSE;
    }
    
    public function removeRole(Role $role): bool {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            return TRUE;
        }
        return FALSE;
    }

    public function getStaff(): Staff {
        return $this->staff;
    }
    
    public function setStaff(Staff $staff) {
        $this->staff = $staff;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'message' => $this->message,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
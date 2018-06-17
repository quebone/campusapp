<?php
namespace Campusapp\Service\Entities;

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
    /** @Column(type="datetime") **/
    private $date;
    /** @Column(type="integer") **/
    private $roleGroup;
    /** @Column(type="integer") **/
    private $sent;
    /** @Column(type="integer") **/
    private $failed;
    /** @ManyToOne(targetEntity="Staff") **/
    private $staff;
    
    public function __construct() {
        $this->title = "";
        $this->body = "";
        $this->message = "";
        $this->date = new \DateTime();
        $this->roleGroup = 0;
        $this->sent = 0;
        $this->failed = 0;
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
    
    public function getRoleGroup(): int {
        return $this->roleGroup;
    }
    
    public function setRoleGroup(int $roleGroup) {
        $this->roleGroup = $roleGroup;
    }
    
    public function getSent(): int {
        return $this->sent;
    }
    
    public function setSent(int $sent) {
        $this->sent = $sent;
    }
    
    public function getFailed(): int {
        return $this->failed;
    }
    
    public function setFailed(int $failed) {
        $this->failed = $failed;
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
            'roleGroup' => $this->roleGroup,
            'sent' => $this->sent,
            'failed' => $this->failed,
            'date' => $this->date->format('d-m-Y H:i:s'),
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
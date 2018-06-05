<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela un administrador
 *
 * @Entity @Table(name="staff")
 */

class Staff implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string", length=40, nullable=true) **/
    private $name;
    /** @Column(type="string", length=70, nullable=true) **/
    private $surnames;
    /** @Column(type="string", length=50, nullable=true) **/
    private $email;
    /** @Column(type="string", length=255, nullable=true) **/
    private $password;
    /** @Column(type="integer") **/
    private $role;
    
    public function __construct() {
        $this->name = "";
        $this->surnames = "";
        $this->email = "";
        $this->password = DEFAULT_PASSWORD;
        $this->role = ADMINISTRATOR;
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getName(): ?string {
        return $this->name;
    }
    
    public function setName(?string $name) {
        $this->name = $name;
    }
    
    public function getSurnames(): ?string {
        return $this->surnames;
    }
    
    public function setSurnames(?string $surnames) {
        $this->surnames = $surnames;
    }
    
    public function getEmail(): ?string {
        return $this->email;
    }
    
    public function setEmail(string $email) {
        $this->email = $email;
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
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surnames' => $this->surnames,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this);
    }
}
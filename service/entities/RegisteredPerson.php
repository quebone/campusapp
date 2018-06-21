<?php
namespace Campusapp\Service\Entities;

/**
 * SuperClasse que modela una persona registrada
 *
 * @Entity
 * @Table(name="registeredpersons")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"user" = "User", "staff" = "Staff"})
 */

abstract class RegisteredPerson extends Person
{
    /** @Column(type="string", length=40, nullable=true) **/
    protected $name;
    /** @Column(type="string", length=70, nullable=true) **/
    protected $surnames;
    /** @Column(type="string", length=50, nullable=true) **/
    protected $email;
    
    public function __construct() {
        parent::__construct();
        $this->name = "";
        $this->surnames = "";
        $this->email = "";
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
}
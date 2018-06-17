<?php
namespace Campusapp\Service\Entities;

/**
 * SuperClasse que modela una persona
 *
 * @Entity
 * @Table(name="persons")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"person"="Person", "registeredperson"="RegisteredPerson", "user"="User", "staff"="Staff"})
 */

class Person implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string", length=255, nullable=true) **/
    protected $regtoken;
    
    public function __construct() {
        $this->regtoken = "";
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function getRegtoken(): ?string {
        return $this->regtoken;
    }
    
    public function setRegtoken(?string $regtoken) {
        $this->regtoken = $regtoken;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'regtoken' => $this->regtoken,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this);
    }
}

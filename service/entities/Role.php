<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela un rol
 *
 * @Entity @Table(name="roles")
 */

class Role implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string", length=15) **/
    private $name;
    
    public function __construct() {
        $this->name = "";
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function setName(string $name) {
        $this->name = $name;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
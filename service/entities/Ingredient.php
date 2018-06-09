<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que modela un ingredient de crep
 *
 * @Entity @Table(name="ingredients")
 */

class Ingredient implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="string", length=100) **/
    private $name;
    /** @Column(type="boolean") **/
    private $visible;
    
    public function __construct() {
        $this->visible = TRUE;
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
    
    public function getVisible(): bool {
        return $this->visible;
    }
    
    public function setVisible(bool $visible) {
        $this->visible = $visible;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'visible' => $this->visible,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
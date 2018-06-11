<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela una comanda de creps
 *
 * @Entity @Table(name="orders")
 */

class Order implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="date") **/
    private $date;
    /** @Column(type="boolean") **/
    private $done;
    /** @Column(type="boolean") **/
    private $warned;
    /** @Column(type="boolean") **/
    private $served;
    /** @ManyToOne(targetEntity="CrepShopper", inversedBy="orders") **/
    private $crepShopper;
    /** @ManyToMany(targetEntity="Ingredient") **/
    private $ingredients;
    
    public function __construct() {
        $this->ingredients = new ArrayCollection();
        $this->date = new \DateTime();
        $this->done = FALSE;
        $this->warned = FALSE;
        $this->served = FALSE;
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getDone(): bool {
        return $this->done;
    }
    
    public function setDone(bool $done) {
        $this->done = $done;
    }
    
    public function getWarned(): bool {
        return $this->warned;
    }
    
    public function setWarned(bool $warned) {
        $this->warned = $warned;
    }
    
    public function getServed(): bool {
        return $this->served;
    }
    
    public function setServed(bool $served) {
        $this->served = $served;
    }
    
    public function getCrepShopper(): CrepShopper {
        return $this->crepShopper;
    }
    
    public function setCrepShopper(CrepShopper $crepShopper) {
        $this->crepShopper = $crepShopper;
    }
    
    public function getIngredients(): ?Selectable {
        return $this->ingredients;
    }
    
    public function setIngredients(Selectable $ingredients) {
        $this->ingredients = $ingredients;
    }
    
    public function addIngredient(Ingredient $ingredient) {
        $this->ingredients->add($ingredient);
    }
    
    public function removeIngredient(Ingredient $ingredient) {
        $this->ingredients->removeElement($ingredient);
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'done' => $this->done,
            'warned' => $this->warned,
            'served' => $this->served,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
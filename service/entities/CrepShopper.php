<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela un comprador de creps
 *
 * @Entity @Table(name="crepshoppers")
 */

class CrepShopper implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @OneToMany(targetEntity="Order", mappedBy="crepShopper") **/
    private $orders;
    /** @OneToOne(targetEntity="Person") **/
    private $person;
    
    public function __construct() {
        $this->orders = new ArrayCollection();
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getRegtoken(): ?string {
        return $this->person->getRegtoken();
    }
    
    public function setRegtoken(string $regtoken) {
        $this->person->setRegtoken($regtoken);
    }
    
    public function getOrders(): ?Selectable {
        return $this->orders;
    }
    
    public function setOrders(Selectable $orders) {
        $this->orders = $orders;
    }
    
    public function getPerson(): Person {
        return $this->person;
    }
    
    public function setPerson(Person $person) {
        $this->person = $person;
    }
    
    public function removeUser(User $user) {
        $this->person = NULL;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'regtoken' => $this->getRegtoken(),
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
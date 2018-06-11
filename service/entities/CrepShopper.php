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
    /** @Column(type="string", length=255, nullable=true) **/
    private $regToken;
    /** @OneToMany(targetEntity="Order", mappedBy="crepShopper") **/
    private $orders;
    /** @OneToOne(targetEntity="User") **/
    private $user;
    
    public function __construct() {
        $this->user = NULL;
        $this->orders = new ArrayCollection();
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getRegToken(): ?string {
        return $this->regToken;
    }
    
    public function setRegToken(string $regToken) {
        $this->regToken = $regToken;
    }
    
    public function getOrders(): ?Selectable {
        return $this->orders;
    }
    
    public function setOrders(Selectable $orders) {
        $this->orders = $orders;
    }
    
    public function getUser(): ?User {
        return $this->user;
    }
    
    public function setuser(?User $user) {
        $this->user = $user;
    }
    
    public function removeUser(User $user) {
        $this->user = NULL;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'regToken' => $this->regToken,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
<?php
namespace Campusapp\Service\Entities;

/**
 * Classe que enregistra variables del sistema
 * Singleton
 *
 * @Entity @Table(name="system")
 */

class System implements IEntity
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;
    /** @Column(type="boolean") **/
    private $crepsEnabled;
    /** @Column(type="boolean") **/
    private $crepsManagerEnabled;
    /** @Column(type="integer") **/
    private $maxPendingCreps;
    /** @Column(type="string", length=20) **/
    private $crepsManagerPassword;
    
    private function __construct() {
    }
    
    public function getId(): int {
        return $this->id;
    }
    
    public function getCrepsEnabled(): bool {
        return $this->crepsEnabled;
    }
    
    public function setCrepsEnabled($crepsEnabled) {
        $this->crepsEnabled = $crepsEnabled;
    }
    
    public function getCrepsManagerEnabled(): bool {
        return $this->crepsManagerEnabled;
    }
    
    public function setCrepsManagerEnabled(bool $crepsManagerEnabled) {
        $this->crepsManagerEnabled = $crepsManagerEnabled;
    }
    
    public function getMaxPendingCreps(): int {
        return $this->maxPendingCreps;
    }
    
    public function setmaxPendingCreps(int $maxPendingCreps) {
        $this->maxPendingCreps = $maxPendingCreps;
    }
    
    public function getCrepsManagerPassword(): string {
        return $this->crepsManagerPassword;
    }
    
    public function setCrepsManagerPassword(string $crepsManagerPassword) {
        $this->crepsManagerPassword = $crepsManagerPassword;
    }
    
    public function toArray(): array {
        return [
            "id" => $this->id,
            'crepsEnabled' => $this->crepsEnabled,
            'maxPendingCreps' => $this->maxPendingCreps,
            'crepsManagerEnabled' => $this->crepsManagerEnabled,
            'crepsManagerPassword' => $this->crepsManagerPassword,
        ];
    }
    
    public function __toString(): string {
        return json_encode($this->toArray());
    }
}
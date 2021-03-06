<?php
namespace Campusapp\Service\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * Classe que modela un usuari
 *
 * @Entity @Table(name="users")
 */

class User extends RegisteredPerson implements IEntity
{
    /** @Column(type="string", length=15, nullable=true) **/
    private $phone;
    /** @Column(type="date", nullable=true) **/
    private $birthDate;
    /** @Column(type="string", length=100, nullable=true) **/
    private $address;
    /** @Column(type="string", length=30, nullable=true) **/
    private $country;
    /** @Column(type="string", length=50, nullable=true) **/
    private $city;
    /** @Column(type="string", length=5, nullable=true) **/
    private $postalCode;
    /** @Column(type="string", length=15, nullable=true) **/
    private $dni;
    /** @Column(type="boolean") **/
    private $privacy;
    /** @OneToMany(targetEntity="Attendance", mappedBy="user") **/
    private $attendances;
    
    public function __construct() {
        parent::__construct();
        $this->phone = "";
        $this->address = "";
        $this->country = "";
        $this->city = "";
        $this->postalCode = "";
        $this->dni = "";
        $this->privacy = FALSE;
        $this->attendances = new ArrayCollection();
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
    
    public function getPhone(): ?string {
        return $this->phone;
    }
    
    public function setPhone(?string $phone) {
        $this->phone = $phone;
    }
    
    public function getBirthdate(): \DateTime {
        return $this->birthDate;
    }
    
    public function setBirthdate($birthDate) {
        if (is_string($birthDate)) $birthDate = \DateTime::createFromFormat('Y-m-d', $birthDate);
        $this->birthDate = $birthDate;
    }
    
    public function getBirthdateAsString(): string {
        return ($this->birthDate == NULL ? "" : $this->birthDate->format('Y-m-d'));
    }
    
    public function getAddress(): ?string {
        return $this->address;
    }
    
    public function setAddress(?string $address) {
        $this->address = $address;
    }
    
    public function getCountry(): ?string {
        return $this->country;
    }
    
    public function setCountry(?string $country) {
        $this->country = $country;
    }
    
    public function getCity(): ?string {
        return $this->city;
    }
    
    public function setCity(?string $city) {
        $this->city = $city;
    }
    
    public function getPostalCode(): ?string {
        return $this->postalCode;
    }
    
    public function setPostalCode(?string $postalCode) {
        $this->postalCode = sprintf('%05d', $postalCode);
    }
    
    public function getDni(): ?string {
        return $this->dni;
    }
    
    public function setDni(?string $dni) {
        $this->dni = $dni;
    }
    
    public function getPrivacy(): bool {
        return $this->privacy;
    }
    
    public function setPrivacy(bool $privacy) {
        $this->privacy = $privacy;
    }
    
    public function getAttendances(): ?Selectable {
        return $this->attendances;
    }
    
    public function setattendances(Selectable $attendances) {
        $this->attendances = $attendances;
    }
    
    public function addAttendance(Attendance $attendance): bool {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances->add($attendance);
            return TRUE;
        }
        return FALSE;
    }
    
    public function removeAttendance(Attendance $attendance): bool {
        if ($this->attendances->contains($attendance)) {
            $this->attendances->removeElement($attendance);
            return TRUE;
        }
        return FALSE;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surnames' => $this->surnames,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthDate' => $this->getBirthdateAsString(),
            'address' => $this->address,
            'country' => $this->country,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'dni' => $this->dni,
            'privacy' => $this->privacy,
            'regtoken' => $this->regtoken,
        ];
    }

    public function __toString(): string {
        return json_encode($this);
    }
}
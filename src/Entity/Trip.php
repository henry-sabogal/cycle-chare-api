<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trips")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Bike::class, inversedBy="trips")
     */
    private $bike;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $trip_date;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="trips_from_station")
     */
    private $from_station_id;

    /**
     * @ORM\ManyToOne(targetEntity=Station::class, inversedBy="trips_to_station")
     */
    private $to_station_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): self
    {
        $this->bike = $bike;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getTripDate(): ?\DateTimeInterface
    {
        return $this->trip_date;
    }

    public function setTripDate(?\DateTimeInterface $trip_date): self
    {
        $this->trip_date = $trip_date;

        return $this;
    }

    public function getFromStationId(): ?Station
    {
        return $this->from_station_id;
    }

    public function setFromStationId(?Station $from_station_id): self
    {
        $this->from_station_id = $from_station_id;

        return $this;
    }

    public function getToStationId(): ?Station
    {
        return $this->to_station_id;
    }

    public function setToStationId(?Station $to_station_id): self
    {
        $this->to_station_id = $to_station_id;

        return $this;
    }
}

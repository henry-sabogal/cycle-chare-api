<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StationRepository::class)
 */
class Station
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lon;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $station_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $current_dockCount;

    /**
     * @ORM\OneToMany(targetEntity=Bike::class, mappedBy="station")
     */
    private $bikes;

    /**
     * @ORM\OneToMany(targetEntity=Trip::class, mappedBy="from_station_id")
     */
    private $trips_from_station;

    /**
     * @ORM\OneToMany(targetEntity=Trip::class, mappedBy="to_station_id")
     */
    private $trips_to_station;

    public function __construct()
    {
        $this->bikes = new ArrayCollection();
        $this->trips_from_station = new ArrayCollection();
        $this->trips_to_station = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(?float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getStationId(): ?string
    {
        return $this->station_id;
    }

    public function setStationId(?string $station_id): self
    {
        $this->station_id = $station_id;

        return $this;
    }

    public function getCurrentDockCount(): ?int
    {
        return $this->current_dockCount;
    }

    public function setCurrentDockCount(?int $current_dockCount): self
    {
        $this->current_dockCount = $current_dockCount;

        return $this;
    }

    /**
     * @return Collection|Bike[]
     */
    public function getBikes(): Collection
    {
        return $this->bikes;
    }

    public function addBike(Bike $bike): self
    {
        if (!$this->bikes->contains($bike)) {
            $this->bikes[] = $bike;
            $bike->setStation($this);
        }

        return $this;
    }

    public function removeBike(Bike $bike): self
    {
        if ($this->bikes->removeElement($bike)) {
            // set the owning side to null (unless already changed)
            if ($bike->getStation() === $this) {
                $bike->setStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTripsFromStation(): Collection
    {
        return $this->trips_from_station;
    }

    public function addTripsFromStation(Trip $tripsFromStation): self
    {
        if (!$this->trips_from_station->contains($tripsFromStation)) {
            $this->trips_from_station[] = $tripsFromStation;
            $tripsFromStation->setFromStationId($this);
        }

        return $this;
    }

    public function removeTripsFromStation(Trip $tripsFromStation): self
    {
        if ($this->trips_from_station->removeElement($tripsFromStation)) {
            // set the owning side to null (unless already changed)
            if ($tripsFromStation->getFromStationId() === $this) {
                $tripsFromStation->setFromStationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTripsToStation(): Collection
    {
        return $this->trips_to_station;
    }

    public function addTripsToStation(Trip $tripsToStation): self
    {
        if (!$this->trips_to_station->contains($tripsToStation)) {
            $this->trips_to_station[] = $tripsToStation;
            $tripsToStation->setToStationId($this);
        }

        return $this;
    }

    public function removeTripsToStation(Trip $tripsToStation): self
    {
        if ($this->trips_to_station->removeElement($tripsToStation)) {
            // set the owning side to null (unless already changed)
            if ($tripsToStation->getToStationId() === $this) {
                $tripsToStation->setToStationId(null);
            }
        }

        return $this;
    }
}

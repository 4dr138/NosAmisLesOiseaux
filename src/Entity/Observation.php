<?php

namespace App\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 */
class Observation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="date_observation", type="datetime")
     */
    private $dateObservation;

    /**
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bird", inversedBy="observations")
     */
    private $bird;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="observations")
     */
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function getDateObservation(): ?datetime
    {
        return $this->dateObservation;
    }

    public function setDateObservation(datetime $dateObservation): self
    {
        $this->dateObservation = $dateObservation;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getBird(): ?Bird
    {
        return $this->bird;
    }

    public function setBird(?Bird $bird): self
    {
        $this->bird = $bird;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}

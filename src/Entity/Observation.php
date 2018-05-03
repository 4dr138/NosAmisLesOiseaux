<?php

namespace App\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservationRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="integer")
     */
    private $bird;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="observations")
     * @ORM\Column(type="integer")
     */
    private $user;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;


    public function __construct()
    {
        $this->dateObservation = new \DateTime();
        $this->updatedAt= new \DateTime();
    }

    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if (null != $image) {
//            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

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

    public function getBird(): ?int
    {
        return $this->bird;
    }

    public function setBird(int $bird): self
    {
        $this->bird = $bird;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }
}

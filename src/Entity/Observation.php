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
     * @ORM\Column(name="latitude", type="string", length=20)
     */
    private $latitude;

    /**
     * @ORM\Column(name="longitude", type="string", length=20)
     */
    private $longitude;

    /**
     * @ORM\Column(name="comment", type="text")
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

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $birdName;


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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBirdName(): ?string
    {
        return $this->birdName;
    }

    public function setBirdName(string $birdName): self
    {
        $this->birdName = $birdName;

        return $this;
    }
}

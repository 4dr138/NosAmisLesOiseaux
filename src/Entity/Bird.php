<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BirdRepository")
 */
class Bird
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="taxref_classe", type="string", length=50)
     */
    private $taxrefClass;

    /**
     * @ORM\Column(name="taxref_cd_nom", type="integer")
     */
    private $taxrefCdName;

    /**
     * @ORM\Column(name="taxref_nom_vern", type="string", length=255)
     */
    private $taxrefVern;

    /**
     * @ORM\Column(name="taxref_url_image", type="string", length=255, nullable=true)
     */
    private $taxrefUrlImage;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $protected;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BirdStatus", inversedBy="birds")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $birdStatus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BirdFamily", inversedBy="birds")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $birdFamily;

    public function __construct()
    {
        $this->taxrefClass = 'Aves';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTaxrefClass(): ?string
    {
        return $this->taxrefClass;
    }

    public function setTaxrefClass(string $taxrefClass): self
    {
        $this->taxrefClass = $taxrefClass;

        return $this;
    }

    public function getTaxrefCdName(): ?int
    {
        return $this->taxrefCdName;
    }

    public function setTaxrefCdName(int $taxrefCdName): self
    {
        $this->taxrefCdName = $taxrefCdName;

        return $this;
    }

    public function getTaxrefVern(): ?string
    {
        return $this->taxrefVern;
    }

    public function setTaxrefVern(string $taxrefVern): self
    {
        $this->taxrefVern = $taxrefVern;

        return $this;
    }

    public function getTaxrefUrlImage(): ?string
    {
        return $this->taxrefUrlImage;
    }

    public function setTaxrefUrlImage(?string $taxrefUrlImage): self
    {
        $this->taxrefUrlImage = $taxrefUrlImage;

        return $this;
    }

    public function getProtected(): ?bool
    {
        return $this->protected;
    }

    public function setProtected(?bool $protected): self
    {
        $this->protected = $protected;

        return $this;
    }

    public function getBirdStatus(): ?int
    {
        return $this->birdStatus;
    }

    public function setBirdStatus(?int $birdStatus): self
    {
        $this->birdStatus = $birdStatus;

        return $this;
    }

    public function getBirdFamily(): ?int
    {
        return $this->birdFamily;
    }

    public function setBirdFamily(?int $birdFamily): self
    {
        $this->birdFamily = $birdFamily;

        return $this;
    }
}

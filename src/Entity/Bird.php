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
     * @ORM\Column(type="string", length=50)
     */
    private $taxref_classe;

    /**
     * @ORM\Column(type="integer")
     */
    private $taxref_cd_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $taxref_nom_vern;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taxref_url_image;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $protected;

    public function getId()
    {
        return $this->id;
    }

    public function getTaxrefClasse(): ?string
    {
        return $this->taxref_classe;
    }

    public function setTaxrefClasse(string $taxref_classe): self
    {
        $this->taxref_classe = $taxref_classe;

        return $this;
    }

    public function getTaxrefCdNom(): ?int
    {
        return $this->taxref_cd_nom;
    }

    public function setTaxrefCdNom(int $taxref_cd_nom): self
    {
        $this->taxref_cd_nom = $taxref_cd_nom;

        return $this;
    }

    public function getTaxrefNomVern(): ?string
    {
        return $this->taxref_nom_vern;
    }

    public function setTaxrefNomVern(string $taxref_nom_vern): self
    {
        $this->taxref_nom_vern = $taxref_nom_vern;

        return $this;
    }

    public function getTaxrefUrlImage(): ?string
    {
        return $this->taxref_url_image;
    }

    public function setTaxrefUrlImage(?string $taxref_url_image): self
    {
        $this->taxref_url_image = $taxref_url_image;

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
}

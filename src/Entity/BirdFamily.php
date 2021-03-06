<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BirdFamilyRepository")
 */
class BirdFamily
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bird", mappedBy="birdFamily")
     */
    private $birds;

    public function __construct()
    {
        $this->birds = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Bird[]
     */
    public function getBirds(): Collection
    {
        return $this->birds;
    }

    public function addBird(Bird $bird): self
    {
        if (!$this->birds->contains($bird)) {
            $this->birds[] = $bird;
            $bird->setBirdFamily($this);
        }

        return $this;
    }

    public function removeBird(Bird $bird): self
    {
        if ($this->birds->contains($bird)) {
            $this->birds->removeElement($bird);
            // set the owning side to null (unless already changed)
            if ($bird->getBirdFamily() === $this) {
                $bird->setBirdFamily(null);
            }
        }

        return $this;
    }
}

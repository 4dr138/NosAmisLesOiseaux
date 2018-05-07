<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;


    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="articleID")
     */
    private $articleID;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecomment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $signalement;



    public function __construct()
    {
        $this->signalement = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getArticleID(): ?int
    {
        return $this->articleID;
    }

    public function setArticleID(int $articleID): self
    {
        $this->articleID = $articleID;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDatecomment(): ?\DateTimeInterface
    {
        return $this->datecomment;
    }

    public function setDatecomment(\DateTimeInterface $datecomment): self
    {
        $this->datecomment = $datecomment;

        return $this;
    }

    public function getSignalement(): ?bool
    {
        return $this->signalement;
    }

    public function setSignalement(bool $signalement): self
    {
        $this->signalement = $signalement;

        return $this;
    }

}

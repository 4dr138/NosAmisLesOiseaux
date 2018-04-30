<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @Vich\Uploadable
 */
class Users implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="userID")
     * @ORM\OneToMany(targetEntity="App\Entity\Birds", mappedBy="userID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $godfatherCode;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $experience;


    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $godsonCode;

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
     * @ORM\Column(type="boolean")
     */
    private $isParrained;

//    /**
//     * @ORM\Column(type="integer")
//     *
//     * @var integer
//     */
//    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;



    public function __construct()
    {
        $this->isActive = true;
        $this->newsletter = true;
        $this->Role ='ROLE_AMATEUR';
        $this->experience = 10 ;
        $this->isParrained = false;
        $this->updatedAt= new \DateTime();
    }

    public function getSalt()
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    public function getRoles()
    {
        return $this->roles;
    }

    public function getGodfatherCode(): ?string
    {
        return $this->godfatherCode;
    }

    public function setGodfatherCode(string $godfatherCode): self
    {
        $this->godfatherCode = $godfatherCode;

        return $this;
    }
        public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getGodsonCode(): ?string
    {
        return $this->godsonCode;
    }

    public function setGodsonCode(string $godsonCode): self
    {
        $this->godsonCode = $godsonCode;

        return $this;
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

    public function getIsParrained(): ?bool
    {
        return $this->isParrained;
    }

    public function setIsParrained(bool $isParrained): self
    {
        $this->isParrained = $isParrained;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->newsletter,
            $this->firstname,
            $this->id,
            $this->mail,
            $this->name,
            $this->password,
            $this->roles,
            $this->godfatherCode,
            $this->experience,
            $this->godsonCode,
            $this->isActive,
        ));
    }
    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->newsletter,
            $this->firstname,
            $this->id,
            $this->mail,
            $this->name,
            $this->password,
            $this->roles,
            $this->godfatherCode,
            $this->experience,
            $this->godsonCode,
            $this->isActive,
            ) = unserialize($serialized);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

//    public function setImageSize(?int $imageSize): void
//    {
//        $this->imageSize = $imageSize;
//    }
//
//    public function getImageSize(): ?int
//    {
//        return $this->imageSize;
//    }
}

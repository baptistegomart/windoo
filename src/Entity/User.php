<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields = {"username"},
 * message = "Ce pseudo existe déjà!")
 */
class User implements UserInterface
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Idea", mappedBy="author", orphanRemoval=true)
     */
    private $idea;

   /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="votre mdp doit faire 8 caractères minimum")
     * @Assert\EqualTo(propertyPath="confirm_password", message="les 2 mots de passe doivent être identiques")
     */
    private $password;

    
    /**
     * @Assert\EqualTo(propertyPath="password", message="les 2 mots de passe doivent être identiques")
     */
   

    public $confirm_password;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;



    public function __construct()
    {
        $this->idea = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    /**
     * @return Collection|Idea[]
     */
    public function getIdea(): Collection
    {
        return $this->idea;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->idea->contains($idea)) {
            $this->idea[] = $idea;
            $idea->setAuthor($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->idea->contains($idea)) {
            $this->idea->removeElement($idea);
            // set the owning side to null (unless already changed)
            if ($idea->getAuthor() === $this) {
                $idea->setAuthor(null);
            }
        }

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


    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRoles()
    {
        return $this->status === 0 ? ['ROLE_USER'] : ['ROLE_ADMIN'];
    }
}

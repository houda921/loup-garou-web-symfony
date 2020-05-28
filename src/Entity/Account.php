<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_admin = false;

    /**
     * @ORM\OneToMany(targetEntity=Party::class, mappedBy="creator")
     */
    private $parties_created;

    /**
     * @ORM\ManyToMany(targetEntity=Party::class, mappedBy="players")
     */
    private $parties_playing;

    public function __construct()
    {
        $this->parties_created = new ArrayCollection();
        $this->parties_playing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(?bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    /**
     * @return Collection|Party[]
     */
    public function getPartiesCreated(): Collection
    {
        return $this->parties_created;
    }

    public function addPartiesCreated(Party $partiesCreated): self
    {
        if (!$this->parties_created->contains($partiesCreated)) {
            $this->parties_created[] = $partiesCreated;
            $partiesCreated->setCreator($this);
        }

        return $this;
    }

    public function removePartiesCreated(Party $partiesCreated): self
    {
        if ($this->parties_created->contains($partiesCreated)) {
            $this->parties_created->removeElement($partiesCreated);
            // set the owning side to null (unless already changed)
            if ($partiesCreated->getCreator() === $this) {
                $partiesCreated->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Party[]
     */
    public function getPartiesPlaying(): Collection
    {
        return $this->parties_playing;
    }

    public function addPartiesPlaying(Party $partiesPlaying): self
    {
        if (!$this->parties_playing->contains($partiesPlaying)) {
            $this->parties_playing[] = $partiesPlaying;
            $partiesPlaying->addPlayer($this);
        }

        return $this;
    }

    public function removePartiesPlaying(Party $partiesPlaying): self
    {
        if ($this->parties_playing->contains($partiesPlaying)) {
            $this->parties_playing->removeElement($partiesPlaying);
            $partiesPlaying->removePlayer($this);
        }

        return $this;
    }
}

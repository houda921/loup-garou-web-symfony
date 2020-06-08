<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_faction = 1;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=510)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_unique = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active_at_night = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_path = "roles/DEFAULT.png";

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="role")
     */
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFaction(): ?int
    {
        return $this->id_faction;
    }

    public function setIdFaction(int $id_faction): self
    {
        $this->id_faction = $id_faction;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsUnique(): ?bool
    {
        return $this->is_unique;
    }

    public function setIsUnique(bool $is_unique): self
    {
        $this->is_unique = $is_unique;

        return $this;
    }

    public function getActiveAtNight(): ?bool
    {
        return $this->active_at_night;
    }

    public function setActiveAtNight(bool $active_at_night): self
    {
        $this->active_at_night = $active_at_night;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): self
    {
        $this->image_path = $image_path;

        return $this;
    }



    public function getFactionColor(): ?string
    {
        switch($this->id_faction)
        {
            case 1:
                return "#1e88e5";
            break;

            case 2:
                return "#7b1b24";
            break;

            case 3:
                return "#1de9b6";
            break;
        }

        return "#00FF00";
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setRole($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getRole() === $this) {
                $player->setRole(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RoleRepository;
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
    private $id_faction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=510)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_unique;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active_at_night;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_path;


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
}

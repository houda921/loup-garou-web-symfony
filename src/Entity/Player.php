<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Party::class, inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $party;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_party_admin = false;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="players")
     * @ORM\JoinColumn(nullable=true)
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="players")
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getIsPartyAdmin(): ?bool
    {
        return $this->is_party_admin;
    }

    public function setIsPartyAdmin(bool $is_party_admin): self
    {
        $this->is_party_admin = $is_party_admin;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}

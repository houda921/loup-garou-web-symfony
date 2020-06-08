<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Player;

/**
 * @ORM\Entity(repositoryClass=PartyRepository::class)
 */
class Party
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
     * @ORM\Column(type="boolean")
     */
    private $is_open = true;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="party")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->is_open;
    }

    public function setIsOpen(bool $is_open): self
    {
        $this->is_open = $is_open;

        return $this;
    }

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        // We initialize an array
        $data = [];

        // We iterate through the players
        foreach ($this->players as $player) {
            // If the player IS linked to an Account : Add !
            if($player->getAccount() != null)
            {
                $data[] = $player;
            }
        }
        
        // We return the array
        return $data;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setParty($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getParty() === $this) {
                $player->setParty(null);
            }
        }

        return $this;
    }


    /** During the setup of a Party, returns all the Roles preconfigured
     * @return Player[]
     */
    public function getSetUpRoles()
    {
        // We initialize an array
        $setUpRoles = [];

        // We iterate through the players
        foreach ($this->players as $player) {
            // If the player IS NOT linked to an Account, but ONLY to a role : Add !
            if($player->getAccount() == null && $player->getRole() != null)
            {
                $setUpRoles[] = $player;
            }
        }

        // We return the array
        return $setUpRoles;
    }


    /** During the setup of a Party, returns all the Roles preconfigured
     * @return Player[]
     */
    public function getSetUpRolesByFaction($factionId)
    {
        // We get the setup roles
        $setUpRoles = $this->getSetUpRoles();
        $byFaction = [];

        foreach ($setUpRoles as $player) {
            if($player->getRole()->getIdFaction() == $factionId) {
                $byFaction[] = $player;
            }
        }

        // We return the array
        return $byFaction;
    }


    /** During the setup of a Party, returns all the Accounts preconfigured
     * @return Player[]
     */
    public function getSetUpAccounts()
    {
        // We initialize an array
        $setUpAccounts = [];

        // We iterate through the players
        foreach ($this->players as $player) {
            // If the player IS linked to an Account, but NOT to a role : Add !
            if($player->getAccount() != null && $player->getRole() == null)
            {
                $setUpAccounts[] = $player;
            }
        }

        // We return the array
        return $setUpAccounts;
    }



    /** Amount of a given role in a party
     * @return int
     */
    public function getCptRole($role): int
    {
        // We initialize a counter
        $cpt = 0;

        // We iterate through the players
        foreach ($this->players as $player) {
            if($player->getRole() == $role)
            {
                $cpt++;
            }
        }

        // We return the counter
        return $cpt;
    }


    
    /**
     * @return Player
     */
    public function getAdmin(): Player
    {
        foreach ($this->players as $player) {
            if($player->getIsPartyAdmin()) {
                return $player;
            }
        }

        return null;
    }
}
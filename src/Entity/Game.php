<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Leader", mappedBy="game")
     */
    private $leader;

    /**
     * @ORM\Column(type="datetime")
     */
    private $gameDate;

    public function __construct()
    {
        $this->leader = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Leader[]
     */
    public function getLeader(): Collection
    {
        return $this->leader;
    }

    public function addLeader(Leader $leader): self
    {
        if (!$this->leader->contains($leader)) {
            $this->leader[] = $leader;
            $leader->setGame($this);
        }

        return $this;
    }

    public function removeLeader(Leader $leader): self
    {
        if ($this->leader->contains($leader)) {
            $this->leader->removeElement($leader);
            // set the owning side to null (unless already changed)
            if ($leader->getGame() === $this) {
                $leader->setGame(null);
            }
        }

        return $this;
    }

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(\DateTimeInterface $gameDate): self
    {
        $this->gameDate = $gameDate;

        return $this;
    }
}

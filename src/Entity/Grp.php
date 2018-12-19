<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrpRepository")
 */
class Grp
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
     * @ORM\OneToMany(targetEntity="App\Entity\GrpsUsers", mappedBy="grpId")
     */
    private $grpsUsers;

    public function __construct()
    {
        $this->grpsUsers = new ArrayCollection();
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

    /**
     * @return Collection|GrpsUsers[]
     */
    public function getGrpsUsers(): Collection
    {
        return $this->grpsUsers;
    }

    public function addGrpsUser(GrpsUsers $grpsUser): self
    {
        if (!$this->grpsUsers->contains($grpsUser)) {
            $this->grpsUsers[] = $grpsUser;
            $grpsUser->setGrpId($this);
        }

        return $this;
    }

    public function removeGrpsUser(GrpsUsers $grpsUser): self
    {
        if ($this->grpsUsers->contains($grpsUser)) {
            $this->grpsUsers->removeElement($grpsUser);
            // set the owning side to null (unless already changed)
            if ($grpsUser->getGrpId() === $this) {
                $grpsUser->setGrpId(null);
            }
        }

        return $this;
    }
}

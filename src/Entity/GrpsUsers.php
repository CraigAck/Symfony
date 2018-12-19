<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrpsUsersRepository")
 */
class GrpsUsers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grp", inversedBy="grpsUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $grpId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="grpsUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrpId(): ?Grp
    {
        return $this->grpId;
    }

    public function setGrpId(?Grp $grpId): self
    {
        $this->grpId = $grpId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}

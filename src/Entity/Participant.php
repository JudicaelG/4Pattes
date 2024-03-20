<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'participants')]
    private Collection $user_id;

    #[ORM\ManyToMany(targetEntity: Ride::class, inversedBy: 'participants')]
    private Collection $Ride_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->Ride_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->user_id->removeElement($userId);

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRideId(): Collection
    {
        return $this->Ride_id;
    }

    public function addRideId(Ride $rideId): static
    {
        if (!$this->Ride_id->contains($rideId)) {
            $this->Ride_id->add($rideId);
        }

        return $this;
    }

    public function removeRideId(Ride $rideId): static
    {
        $this->Ride_id->removeElement($rideId);

        return $this;
    }
}

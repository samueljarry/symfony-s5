<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['actor:read']],
)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['actor:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    #[Groups(['movie:read', 'actor:read'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 70)]
    #[Groups(['movie:read', 'actor:read'])]
    private ?string $lastName = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actor')]
    #[Groups(['actor:read'])]
    private Collection $movies;

    #[ORM\ManyToMany(targetEntity: Nationality::class, mappedBy: 'actors')]
    private Collection $nationalities;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->nationalities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeActor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Nationality>
     */
    public function getNationalities(): Collection
    {
        return $this->nationalities;
    }

    public function addNationality(Nationality $nationality): static
    {
        if (!$this->nationalities->contains($nationality)) {
            $this->nationalities->add($nationality);
            $nationality->addActor($this);
        }

        return $this;
    }

    public function removeNationality(Nationality $nationality): static
    {
        if ($this->nationalities->removeElement($nationality)) {
            $nationality->removeActor($this);
        }

        return $this;
    }
}
<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiProperty;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['movie:read']],
)]
#[ApiFilter(BooleanFilter::class, properties: ['online'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partial'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[ApiProperty(types: ['https://schema.org/image'])]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    public ?MediaObject $image = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank(message: 'Vous devez spécifier une catégorie.')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private Collection $actor;

    #[ORM\Column(length: 70)]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    #[Assert\NotBlank(message: 'Le titre ne doit pas être vide.')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "Le titre doit avoir au moins {{ limit }} caractères.",
        maxMessage: "Le titre doit avoir moins de {{ limit }} caractères.",
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'La description ne doit pas être vide.')]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\Type(type: "string")]
    private ?string $releaseDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\Type(type: "integer")]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read', 'actor:read'])]
    private ?bool $online = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    private ?float $note = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "integer")]
    #[Groups(['movie:read'])]
    private ?int $entries = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "integer")]
    #[Groups(['movie:read'])]
    private ?int $budget = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string")]
    #[Assert\NotBlank(message: 'Le réalisateur ne doit pas être vide.')]
    #[Groups(['movie:read'])]
    private ?string $director = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Type(type: "string")]
    #[Groups(['movie:read'])]
    private ?string $website = null;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(?bool $online): static
    {
        $this->online = $online;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): static
    {
        $this->image = $image;

        return $this;
    }
}

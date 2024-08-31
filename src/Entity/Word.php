<?php

namespace App\Entity;

use App\Enum\DialectEnum;
use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: WordRepository::class)]
#[UniqueEntity(fields: ['name', 'dialect'])]
#[Index(columns: ["name"])]

class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: DialectEnum::class)]
    private ?DialectEnum $dialect = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explanation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pronunciation = null;

    /**
     * @var Collection<int, Pronunciation>
     */
    #[ORM\OneToMany(targetEntity: Pronunciation::class, mappedBy: 'word', orphanRemoval: true)]
    private Collection $pronunciations;

    public function __construct()
    {
        $this->pronunciations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDialect(): ?DialectEnum
    {
        return $this->dialect;
    }

    public function setDialect(DialectEnum $dialect): static
    {
        $this->dialect = $dialect;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getPronunciation(): ?string
    {
        return $this->pronunciation;
    }

    public function setPronunciation(?string $pronunciation): static
    {
        $this->pronunciation = $pronunciation;

        return $this;
    }

    /**
     * @return Collection<int, Pronunciation>
     */
    public function getPronunciations(): Collection
    {
        return $this->pronunciations;
    }

    public function addPronunciation(Pronunciation $pronunciation): static
    {
        if (!$this->pronunciations->contains($pronunciation)) {
            $this->pronunciations->add($pronunciation);
            $pronunciation->setWord($this);
        }

        return $this;
    }

    public function removePronunciation(Pronunciation $pronunciation): static
    {
        if ($this->pronunciations->removeElement($pronunciation)) {
            // set the owning side to null (unless already changed)
            if ($pronunciation->getWord() === $this) {
                $pronunciation->setWord(null);
            }
        }

        return $this;
    }
}

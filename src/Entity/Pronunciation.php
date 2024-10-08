<?php

namespace App\Entity;

use App\Enum\DialectEnum;
use App\Repository\PronunciationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PronunciationRepository::class)]
#[ORM\UniqueConstraint(
    name: 'pronunciation_word_dialect_source_unique_idx',
    columns: ['word_id', 'dialect', 'source']
)]
class Pronunciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: DialectEnum::class)]
    private ?DialectEnum $dialect = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phonetically = null;

    #[ORM\ManyToOne(inversedBy: 'pronunciations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $word = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getPhonetically(): ?string
    {
        return $this->phonetically;
    }

    public function setPhonetically(?string $phonetically): static
    {
        $this->phonetically = $phonetically;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }
}

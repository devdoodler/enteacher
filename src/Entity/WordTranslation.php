<?php

namespace App\Entity;

use App\Repository\WordTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: WordTranslationRepository::class)]
#[ORM\UniqueConstraint(
    name: 'word_translation_priority_unique_idx',
    columns: ['word_id', 'translation_id', 'priority']
)]
class WordTranslation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $Word = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Translation $Translation = null;

    #[ORM\Column]
    private ?int $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?Word
    {
        return $this->Word;
    }

    public function setWord(?Word $Word): static
    {
        $this->Word = $Word;

        return $this;
    }

    public function getTranslation(): ?Translation
    {
        return $this->Translation;
    }

    public function setTranslation(?Translation $Translation): static
    {
        $this->Translation = $Translation;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}

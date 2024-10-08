<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class Translation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explanation = null;

    #[ORM\OneToOne(mappedBy: 'Translation', cascade: ['persist', 'remove'])]
    private ?TranslationPron $translationPron = null;

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

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getTranslationPron(): ?TranslationPron
    {
        return $this->translationPron;
    }

    public function setTranslationPron(TranslationPron $translationPron): static
    {
        // set the owning side of the relation if necessary
        if ($translationPron->getTranslation() !== $this) {
            $translationPron->setTranslation($this);
        }

        $this->translationPron = $translationPron;

        return $this;
    }
}

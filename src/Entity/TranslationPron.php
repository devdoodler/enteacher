<?php

namespace App\Entity;

use App\Repository\TranslationPronRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationPronRepository::class)]
class TranslationPron
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'translationPron', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Translation $Translation = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTranslation(): ?Translation
    {
        return $this->Translation;
    }

    public function setTranslation(Translation $Translation): static
    {
        $this->Translation = $Translation;

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
}

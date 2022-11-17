<?php

namespace App\Entity;

use App\Repository\SwitchactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SwitchactionRepository::class)]
class Switchaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pressbtn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $langOne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LangTwo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPressbtn(): ?bool
    {
        return $this->pressbtn;
    }

    public function setPressbtn(?bool $pressbtn): self
    {
        $this->pressbtn = $pressbtn;

        return $this;
    }

    public function getLangOne(): ?string
    {
        return $this->langOne;
    }

    public function setLangOne(?string $langOne): self
    {
        $this->langOne = $langOne;

        return $this;
    }

    public function getLangTwo(): ?string
    {
        return $this->LangTwo;
    }

    public function setLangTwo(?string $LangTwo): self
    {
        $this->LangTwo = $LangTwo;

        return $this;
    }
}

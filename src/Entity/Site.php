<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(min: 1, max: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 250, nullable: true)]
    #[Assert\Length(min: 1, max: 250)]
    private ?string $description = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $keywords = null;

    #[ORM\Column(length: 250, nullable: true)]
    #[Assert\Length(min: 1, max: 250)]
    private ?string $reseaudescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function setKeywords(?array $keywords): static
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getReseaudescription(): ?string
    {
        return $this->reseaudescription;
    }

    public function setReseaudescription(?string $reseaudescription): static
    {
        $this->reseaudescription = $reseaudescription;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }
}

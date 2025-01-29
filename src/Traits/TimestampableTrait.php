<?php
 
namespace App\Traits;
 
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{

    #[ORM\Column(type: 'datetime_immutable', nullable:false)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable', nullable:false)]
    private ?DateTimeImmutable $updatedAt = null;
 
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }
 
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
 
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
 
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
 
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $this->updatedAt = new DateTimeImmutable();
 
        if ($this->createdAt === null) {
            $this->createdAt = new DateTimeImmutable();
        }
    }
}
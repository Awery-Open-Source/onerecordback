<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column]
    public ?int $message_id = null;

    #[ORM\Column(length: 255)]
    public ?string $short = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    public ?string $subject = null;

    #[ORM\Column(length: 255)]
    public ?string $from = null;

    #[ORM\Column(length: 255)]
    public ?string $from_name = null;

    #[ORM\Column(length: 255)]
    public ?string $from_email = null;

    #[ORM\Column(length: 255)]
    public ?string $to = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $body = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    // ... getter and setter methods
}
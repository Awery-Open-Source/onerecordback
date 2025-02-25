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

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $one_record_id = null;
    #[ORM\Column(length: 255, nullable: true)]
    public ?string $message_id = null;

    #[ORM\Column]
    public ?int $awb_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $short = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $type = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $dateAction = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $dateCreate = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $subject = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $location = null;

    #[ORM\Column]
    public ?int $qty = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $text = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $from_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $from_email = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $to_email = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $body = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    // ... getter and setter methods
}
<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Awb
{
    public function __construct()
    {
        if (empty($this->date_create))
        $this->date_create = new \DateTime();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $awb_no = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $one_record_url = null;

    #[ORM\Column(length: 3, nullable: true)]
    public ?string $origin = null;

    #[ORM\Column(length: 3, nullable: true)]
    public ?string $destination = null;

    #[ORM\Column(length: 10, nullable: true)]
    public ?string $weight = null;

    #[ORM\Column(length: 10, nullable: true)]
    public ?string $commodity_code = null;

    #[ORM\Column(length: 10, nullable: true)]
    public ?string $product_type_code = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $date_create = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    // ... getter and setter methods
}
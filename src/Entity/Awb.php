<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Awb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $awb_no = null;

    #[ORM\Column(length: 255)]
    public ?string $one_record_url = null;

    #[ORM\Column(length: 3)]
    public ?string $origin = null;

    #[ORM\Column(length: 3)]
    public ?string $destination = null;

    #[ORM\Column(length: 10)]
    public ?string $weight = null;

    #[ORM\Column(length: 10)]
    public ?string $commodity_code = null;

    #[ORM\Column(length: 10)]
    public ?string $product_type_code = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTime $date_create = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    // ... getter and setter methods
}
<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class PieceAwb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column]
    public ?int $awb_id = null;

    #[ORM\Column]
    public ?string $one_record_id = null;

    #[ORM\Column(length: 10)]
    public ?string $length = null;

    #[ORM\Column(length: 10)]
    public ?string $height = null;

    #[ORM\Column(length: 10)]
    public ?string $width = null;

    #[ORM\Column(length: 10)]
    public ?string $weight = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    // ... getter and setter methods
}
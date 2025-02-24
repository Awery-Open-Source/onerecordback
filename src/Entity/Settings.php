<?php
// src/Entity/Product.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $base_url = null;

    #[ORM\Column(length: 255)]
    public ?string $token = null;

    #[ORM\Column(length: 255)]
    public ?string $email = null;


    public function getId(): ?int
    {
        return $this->id;
    }
}
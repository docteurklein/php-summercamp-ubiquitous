<?php declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Infra\Doctrine\ORM\Repository\Products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="bigint")
     */
    private $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public static function namedAndPriced($name, $price): self
    {
        return new self($name, $price);
    }

    public function getPrice(): int
    {
        return $this->price;;
    }

    function getName() :string
    {
        return $this->name
    }

    public function getId(): int
    {
        return (int)$this->id;
    }
}

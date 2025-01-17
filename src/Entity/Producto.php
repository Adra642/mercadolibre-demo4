<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace App\Entity;

use App\Repository\ProductoRepository;
use CarlosChininin\AttachFile\Model\AttachFile;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Math;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $precio = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $descuento = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductoCategoria $categoria = null;

    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?AttachFile $foto = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vendedor $vendedor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $fechaCreacion = null;

    public function __toString()
    {
        return $this->nombre;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getDescuento(): ?int
    {
        return $this->descuento;
    }

    public function setDescuento(?int $descuento): static
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getCategoria(): ?ProductoCategoria
    {
        return $this->categoria;
    }

    public function setCategoria(?ProductoCategoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getFoto(): ?AttachFile
    {
        return $this->foto;
    }

    public function setFoto(?AttachFile $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getVendedor(): ?Vendedor
    {
        return $this->vendedor;
    }

    public function setVendedor(?Vendedor $vendedor): static
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fechaCreacion): static
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getPrecioDescuento(): float
    {
        $precioFinal = (100 - $this->descuento) / 100  * $this->precio;
        return round($precioFinal, 2);
    }
}

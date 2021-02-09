<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $produit_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $produit_nom;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $produit_prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $produit_quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commandes")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduitId(): ?int
    {
        return $this->produit_id;
    }

    public function setProduitId(int $produit_id): self
    {
        $this->produit_id = $produit_id;

        return $this;
    }

    public function getProduitNom(): ?string
    {
        return $this->produit_nom;
    }

    public function setProduitNom(string $produit_nom): self
    {
        $this->produit_nom = $produit_nom;

        return $this;
    }

    public function getProduitPrix(): ?string
    {
        return $this->produit_prix;
    }

    public function setProduitPrix(string $produit_prix): self
    {
        $this->produit_prix = $produit_prix;

        return $this;
    }

    public function getProduitQuantite(): ?int
    {
        return $this->produit_quantite;
    }

    public function setProduitQuantite(int $produit_quantite): self
    {
        $this->produit_quantite = $produit_quantite;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->createdAt->format('d-m-Y H:i:s'). ' ' .$this->utilisateur;
    }
}

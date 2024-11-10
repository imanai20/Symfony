<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'paiements')]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;


    #[ORM\Column(type: 'string', length: 255)]
    private string $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $montant;

    #[ORM\Column(type: 'string', length: 255)]
    private string $methodePaiement;

    #[ORM\Column(type: 'string', length: 50)]
    private string $statut;

    #[ORM\Column(name: 'numeroCarteBleu', type: 'string', length: 16)]  
    private string $numeroCarteBleu;

    
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getMethodePaiement(): string
    {
        return $this->methodePaiement;
    }

    public function setMethodePaiement(string $methodePaiement): self
    {
        $this->methodePaiement = $methodePaiement;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getNumeroCarteBleu(): string
    {
        return $this->numeroCarteBleu;
    }

    public function setNumeroCarteBleu(string $numeroCarteBleu): self
    {
        $this->numeroCarteBleu = $numeroCarteBleu;
        return $this;
    }
}

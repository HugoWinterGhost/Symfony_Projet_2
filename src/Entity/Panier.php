<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_achat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=ContenuPanier::class, mappedBy="Panier")
     */
    private $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->Utilisateur = $utilisateur;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTimeInterface $date_achat): self
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|ContenuPanier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(ContenuPanier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->setPanier($this);
        }

        return $this;
    }

    public function removePanier(ContenuPanier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getPanier() === $this) {
                $panier->setPanier(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter; // Permet de faire des recherche 
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;  // Permet de filter par ordre alphabétique
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(paginationItemsPerPage: 20, 
operations:[new Get(normalizationContext:['groups' => 'produit:item']),
            new GetCollection(normalizationContext:['groups' => 'produit:list']),
            ])]

#[ApiFilter(OrderFilter::class, properties:['nom' => 'ASC'])] // dit que la recherche est rangé par ordre alpha croissant
#[ApiFilter(SearchFilter::class, properties:['nom' => 'partial'])] // Précique que la recherche peut-être partielle, donc on a juste besoin des première lettres
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['type:list','type:item','produit:list','produit:item'])]
    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[Groups(['type:list','type:item','produit:list','produit:item'])]
    #[ORM\Column]
    private ?float $prixUnite = null;

    #[Groups(['type:list','type:item','produit:list','produit:item'])]
    #[ORM\Column]
    private ?int $quantiteStock = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $idType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixUnite(): ?float
    {
        return $this->prixUnite;
    }

    public function setPrixUnite(float $prixUnite): static
    {
        $this->prixUnite = $prixUnite;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): static
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getIdType(): ?Type
    {
        return $this->idType;
    }

    public function setIdType(?Type $idType): static
    {
        $this->idType = $idType;

        return $this;
    }
}

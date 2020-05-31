<?php

namespace App\Admin\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Admin\Repository\MenuRepository")
 * @UniqueEntity("route")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $structure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Admin\Entity\MenuSociety", mappedBy="menu")
     */
    private $menuSocieties;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    public function __construct()
    {
        $this->menuSocieties = new ArrayCollection();
    }

    public function getCountMenuSociety()
    {
        return count($this->menuSocieties);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStructure(): ?string
    {
        return $this->structure;
    }

    public function setStructure(string $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|MenuSociety[]
     */
    public function getMenuSocieties(): Collection
    {
        return $this->menuSocieties;
    }

    public function addMenuSociety(MenuSociety $menuSociety): self
    {
        if (!$this->menuSocieties->contains($menuSociety)) {
            $this->menuSocieties[] = $menuSociety;
            $menuSociety->setMenu($this);
        }

        return $this;
    }

    public function removeMenuSociety(MenuSociety $menuSociety): self
    {
        if ($this->menuSocieties->contains($menuSociety)) {
            $this->menuSocieties->removeElement($menuSociety);
            // set the owning side to null (unless already changed)
            if ($menuSociety->getMenu() === $this) {
                $menuSociety->setMenu(null);
            }
        }

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }
}

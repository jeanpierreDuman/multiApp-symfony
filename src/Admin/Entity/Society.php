<?php

namespace App\Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Admin\Repository\SocietyRepository")
 */
class Society
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Core\Entity\User", mappedBy="society")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Admin\Entity\MenuSociety", mappedBy="society")
     */
    private $menuSocieties;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->menuSocieties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSociety($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getSociety() === $this) {
                $user->setSociety(null);
            }
        }

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
            $menuSociety->setSociety($this);
        }

        return $this;
    }

    public function removeMenuSociety(MenuSociety $menuSociety): self
    {
        if ($this->menuSocieties->contains($menuSociety)) {
            $this->menuSocieties->removeElement($menuSociety);
            // set the owning side to null (unless already changed)
            if ($menuSociety->getSociety() === $this) {
                $menuSociety->setSociety(null);
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}

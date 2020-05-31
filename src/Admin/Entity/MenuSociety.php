<?php

namespace App\Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Admin\Repository\MenuSocietyRepository")
 */
class MenuSociety
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Admin\Entity\Society", inversedBy="menuSocieties")
     */
    private $society;

    /**
     * @ORM\ManyToOne(targetEntity="App\Admin\Entity\Menu", inversedBy="menuSocieties")
     */
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}

<?php

namespace App\Payment\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Core\Entity\User;
use App\Core\Entity\Customer;

/**
 * @ORM\Entity(repositoryClass="App\Payment\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTransform;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note = null;

    /**
     * @ORM\Column(type="integer")
     */
    private $num;

    /**
     * @ORM\ManyToOne(targetEntity="App\Core\Entity\User", inversedBy="invoices")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Payment\Entity\InvoiceRow", mappedBy="invoice", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $rows;

    /**
     * @ORM\Column(type="float")
     */
    private $tva;

    /**
     * @ORM\Column(type="float")
     */
    private $amountHT;

    /**
     * @ORM\Column(type="float")
     */
    private $subTVA;

    /**
     * @ORM\Column(type="float")
     */
    private $amountTTC;

    /**
     * @ORM\ManyToOne(targetEntity="App\Core\Entity\Customer", inversedBy="invoices")
     */
    private $customer;

    public function __construct()
    {
        $this->rows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getIsTransform(): ?bool
    {
        return $this->isTransform;
    }

    public function setIsTransform(bool $isTransform): self
    {
        $this->isTransform = $isTransform;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|InvoiceRow[]
     */
    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function addRow(InvoiceRow $row): self
    {
        if (!$this->rows->contains($row)) {
            $this->rows[] = $row;
            $row->setInvoice($this);
        }

        return $this;
    }

    public function removeRow(InvoiceRow $row): self
    {
        if ($this->rows->contains($row)) {
            $this->rows->removeElement($row);
            // set the owning side to null (unless already changed)
            if ($row->getInvoice() === $this) {
                $row->setInvoice(null);
            }
        }

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getAmountHT(): ?float
    {
        return $this->amountHT;
    }

    public function setAmountHT(float $amountHT): self
    {
        $this->amountHT = $amountHT;

        return $this;
    }

    public function getSubTVA(): ?float
    {
        return $this->subTVA;
    }

    public function setSubTVA(float $subTVA): self
    {
        $this->subTVA = $subTVA;

        return $this;
    }

    public function getAmountTTC(): ?float
    {
        return $this->amountTTC;
    }

    public function setAmountTTC(float $amountTTC): self
    {
        $this->amountTTC = $amountTTC;

        return $this;
    }
}

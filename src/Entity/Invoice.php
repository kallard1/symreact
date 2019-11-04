<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 *
 * @ApiResource(
 *     subresourceOperations={
 *       "api_customers_invoices_get_subresource"={
 *         "normalization_context"={"groups"={"invoices_subresource"}}
 *       }
 *     },
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 */
class Invoice
{
    /**
     * @var int $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"invoices_subresource"})
     */
    private $id;

    /**
     * @var int $count
     *
     * @ORM\Column(type="string", length=6)
     *
     * @Groups({"invoices_subresource"})
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $count;

    /**
     * @var Product[]|ArrayCollection $products
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     *
     * @Groups({"invoices_subresource"})
     */
    private $products;

    /**
     * @var Customer $customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="invoices")
     *
     * @Assert\NotNull()
     */
    private $customer;

    /**
     * @var Status $status
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"invoices_subresource"})
     *
     * @Assert\NotNull()
     */
    private $status;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(type="datetime")
     *
     * @Groups({"invoices_subresource"})
     */
    private $createdAt;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(type="datetime")
     *
     * @Groups({"invoices_subresource"})
     */
    private $updatedAt;

    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups({"invoices_subresource"})
     *
     * @Assert\Date()
     */
    private $sentAt;

    /**
     * @var User $user
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="invoices")
     *
     * @Assert\NotNull()
     */
    private $user;

    /**
     * Invoice constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Description getId function
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Description getCount function
     *
     * @return string|null
     */
    public function getCount(): ?string
    {
        return $this->count;
    }

    /**
     * Description setCount function
     *
     * @param string $count
     *
     * @return $this
     */
    public function setCount(string $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Description getProducts function
     *
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * Description addProduct function
     *
     * @param Product $product
     *
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    /**
     * Description removeProduct function
     *
     * @param Product $product
     *
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * Description getCustomer function
     *
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Description setCustomer function
     *
     * @param Customer|null $customer
     *
     * @return $this
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Description getStatus function
     *
     * @return Status|null
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * Description setStatus function
     *
     * @param Status|null $status
     *
     * @return $this
     */
    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Description getCreatedAt function
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Description setCreatedAt function
     *
     * @param \DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Description getUpdatedAt function
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Description setUpdatedAt function
     *
     * @param \DateTimeInterface $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Description getSentAt function
     *
     * @return \DateTimeInterface|null
     */
    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    /**
     * Description setSentAt function
     *
     * @param \DateTimeInterface|null $sentAt
     *
     * @return $this
     */
    public function setSentAt(?\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Description getUser function
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Description setUser function
     *
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

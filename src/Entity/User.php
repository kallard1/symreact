<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"users_read"}}
 * )
 *
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @var int $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"customer_read", "users_read"})
     */
    private $id;

    /**
     * @var string $email
     *
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Groups({"customers_read", "users_read"})
     *
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @var mixed[] $roles
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @var string $firstName
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"customers_read", "users_read"})
     *
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=50)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Groups({"customers_read", "users_read"})
     *
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=50)
     */
    private $lastName;

    /**
     * @var Customer[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="user", orphanRemoval=true)
     */
    private $customers;

    /**
     * @var Company[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Company", mappedBy="user", orphanRemoval=true)
     */
    private $companies;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="user")
     */
    private $categories;

    /**
     * @var Product[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="user", orphanRemoval=true)
     */
    private $products;

    /**
     * @var Status[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Status", mappedBy="user", orphanRemoval=true)
     */
    private $statuses;

    /**
     * @var Invoice[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="user")
     */
    private $invoices;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $invoiceCounter = 0;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->statuses = new ArrayCollection();
        $this->invoices = new ArrayCollection();
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
     * Description getEmail function
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Description setEmail function
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Description getUsername function
     *
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Description getRoles function
     *
     * @return mixed[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Description setRoles function
     *
     * @param mixed[] $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Description getPassword function
     *
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Description setPassword function
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Description getSalt function
     *
     * @return string|void|null
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * Description eraseCredentials function
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Description getFirstName function
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Description setFirstName function
     *
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Description getLastName function
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Description setLastName function
     *
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Description getCustomers function
     *
     * @return Collection
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    /**
     * Description addCustomer function
     *
     * @param Customer $customer
     *
     * @return $this
     */
    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setUser($this);
        }

        return $this;
    }

    /**
     * Description removeCustomer function
     *
     * @param Customer $customer
     *
     * @return $this
     */
    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getUser() === $this) {
                $customer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Description getCompanies function
     *
     * @return Collection
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    /**
     * Description addCompany function
     *
     * @param Company $company
     *
     * @return $this
     */
    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setUser($this);
        }

        return $this;
    }

    /**
     * Description removeCompany function
     *
     * @param Company $company
     *
     * @return $this
     */
    public function removeCompany(Company $company): self
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getUser() === $this) {
                $company->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Description getCategories function
     *
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Description addCategory function
     *
     * @param Category $category
     *
     * @return $this
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setUser($this);
        }

        return $this;
    }

    /**
     * Description removeCategory function
     *
     * @param Category $category
     *
     * @return $this
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
        }

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
            $product->setUser($this);
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
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Description getStatuses function
     *
     * @return Collection
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    /**
     * Description addStatus function
     *
     * @param Status $status
     *
     * @return $this
     */
    public function addStatus(Status $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setUser($this);
        }

        return $this;
    }

    /**
     * Description removeStatus function
     *
     * @param Status $status
     *
     * @return $this
     */
    public function removeStatus(Status $status): self
    {
        if ($this->statuses->contains($status)) {
            $this->statuses->removeElement($status);
            // set the owning side to null (unless already changed)
            if ($status->getUser() === $this) {
                $status->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Description getInvoices function
     *
     * @return Collection
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    /**
     * Description addInvoice function
     *
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setUser($this);
        }

        return $this;
    }

    /**
     * Description removeInvoice function
     *
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getUser() === $this) {
                $invoice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Description getInvoiceCounter function
     *
     * @return int|null
     */
    public function getInvoiceCounter(): ?int
    {
        return $this->invoiceCounter;
    }

    /**
     * Description setInvoiceCounter function
     *
     * @param int $invoiceCounter
     *
     * @return $this
     */
    public function setInvoiceCounter(int $invoiceCounter): self
    {
        $this->invoiceCounter = $invoiceCounter;

        return $this;
    }
}

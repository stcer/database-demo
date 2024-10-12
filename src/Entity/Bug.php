<?php

namespace demo\Entity;

use DateTime;
use demo\Repo\BugRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BugRepository::class)]
#[ORM\Table(name: 'bugs')]
class Bug
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    #[ORM\Column(type: 'string')]
    private string $status;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'assignedBugs')]
    private User|null $engineer = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reportedBugs')]
    private User|null $reporter;


    /** @var Collection<int, Product> */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function setEngineer(User $engineer): void
    {
        $engineer->assignedToBug($this);
        $this->engineer = $engineer;
    }

    public function setReporter(User $reporter): void
    {
        $reporter->addReportedBug($this);
        $this->reporter = $reporter;
    }

    public function getEngineer(): User
    {
        return $this->engineer;
    }

    public function getReporter(): User
    {
        return $this->reporter;
    }

    public function assignToProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /** @return Collection<int, Product> */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getStatus():string
    {
        return $this->status;
    }

    public function close()
    {
        $this->status = "CLOSE";
    }
}
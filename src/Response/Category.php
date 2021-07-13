<?php

declare(strict_types = 1);

namespace ThinkOut\Response;

class Category implements ResponseInterface
{
    private string $id;
    private string $name;
    private int $type;
    private ?string $parentId;

    /**
     * @var array<int, Category>|null
     */
    private ?array $children;

    /**
     * @param array<int, Category>|null $children
     */
    public function __construct(
        string $id,
        string $name,
        int $type,
        ?string $parentId,
        ?array $children
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->parentId = $parentId;
        $this->children = $children;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function getChildren(): ?array
    {
        return $this->children;
    }
}

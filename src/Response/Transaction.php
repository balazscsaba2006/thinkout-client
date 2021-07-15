<?php

declare(strict_types = 1);

namespace ThinkOut\Response;

class Transaction implements ResponseInterface
{
    private string $id;
    private string $accountId;
    private float $amount;
    private string $categoryId;
    private float $convertedAmount;
    private string $currencyId;
    private \DateTimeInterface $dateTime;
    private string $description;
    private bool $isPending;
    private string $source;
    private int $type;

    public function __construct(
        string $id,
        string $accountId,
        float $amount,
        string $categoryId,
        float $convertedAmount,
        string $currencyId,
        \DateTimeInterface $dateTime,
        string $description,
        bool $isPending,
        string $source,
        int $type
    ) {
        $this->id = $id;
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->categoryId = $categoryId;
        $this->convertedAmount = $convertedAmount;
        $this->currencyId = $currencyId;
        $this->dateTime = $dateTime;
        $this->description = $description;
        $this->isPending = $isPending;
        $this->source = $source;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getConvertedAmount(): float
    {
        return $this->convertedAmount;
    }

    public function getCurrencyId(): string
    {
        return $this->currencyId;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isPending(): bool
    {
        return $this->isPending;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getType(): int
    {
        return $this->type;
    }
}

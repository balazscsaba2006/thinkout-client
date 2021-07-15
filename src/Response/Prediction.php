<?php

declare(strict_types = 1);

namespace ThinkOut\Response;

class Prediction implements ResponseInterface
{
    private string $id;
    private float $amount;
    private string $categoryId;
    private string $comment;
    private float $convertedAmount;
    private string $currencyId;
    private \DateTimeInterface $dateTime;
    private bool $isOverdue;
    private bool $isRealised;
    private string $description;
    /** @var string[] */
    private array $linkedTransactions;
    private int $type;
    private bool $isTouched;
    private float $remainingAmount;

    public function __construct(
        string $id,
        float $amount,
        string $categoryId,
        string $comment,
        float $convertedAmount,
        string $currencyId,
        \DateTimeInterface $dateTime,
        bool $isOverdue,
        bool $isRealised,
        string $description,
        array $linkedTransactions,
        int $type,
        bool $isTouched,
        float $remainingAmount
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->categoryId = $categoryId;
        $this->comment = $comment;
        $this->convertedAmount = $convertedAmount;
        $this->currencyId = $currencyId;
        $this->dateTime = $dateTime;
        $this->isOverdue = $isOverdue;
        $this->isRealised = $isRealised;
        $this->description = $description;
        $this->linkedTransactions = $linkedTransactions;
        $this->type = $type;
        $this->isTouched = $isTouched;
        $this->remainingAmount = $remainingAmount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getComment(): string
    {
        return $this->comment;
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

    public function isOverdue(): bool
    {
        return $this->isOverdue;
    }

    public function isRealised(): bool
    {
        return $this->isRealised;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getLinkedTransactions(): array
    {
        return $this->linkedTransactions;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function isTouched(): bool
    {
        return $this->isTouched;
    }

    public function getRemainingAmount(): float
    {
        return $this->remainingAmount;
    }
}

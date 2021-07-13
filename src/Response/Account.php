<?php

declare(strict_types = 1);

namespace ThinkOut\Response;

class Account implements ResponseInterface
{
    private string $id;
    private float $balance;
    private string $currency;
    private string $currencyId;
    private float $initialBalance;
    private \DateTimeInterface $initialDateTime;
    private string $name;
    private string $originalName;
    private string $source;
    private string $bankName;

    public function __construct(
        string $id,
        float $balance,
        string $currency,
        string $currencyId,
        float $initialBalance,
        \DateTimeInterface $initialDateTime,
        string $name,
        string $originalName,
        string $source,
        string $bankName
    ) {
        $this->id = $id;
        $this->balance = $balance;
        $this->currency = $currency;
        $this->currencyId = $currencyId;
        $this->initialBalance = $initialBalance;
        $this->initialDateTime = $initialDateTime;
        $this->name = $name;
        $this->originalName = $originalName;
        $this->source = $source;
        $this->bankName = $bankName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCurrencyId(): string
    {
        return $this->currencyId;
    }

    public function getInitialBalance(): float
    {
        return $this->initialBalance;
    }

    public function getInitialDateTime(): \DateTimeInterface
    {
        return $this->initialDateTime;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getBankName(): string
    {
        return $this->bankName;
    }
}

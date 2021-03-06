<?php

namespace CLightning;

class Invoice
{
    protected $label;
    protected $description;
    protected $status;
    protected $msatoshi;
    protected $msatoshiReceived;
    protected $bolt11;
    protected $payIndex;
    protected $paymentHash;
    protected $paidTimestamp;
    protected $paidAt;
    protected $expiryTime;
    protected $expiresAt;

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setMsatoshi(int $msatoshi): void
    {
        $this->msatoshi = $msatoshi;
    }

    public function setBolt11(string $bolt11): void
    {
        $this->bolt11 = $bolt11;
    }

    public function setPaymentHash(string $paymentHash): void
    {
        $this->paymentHash = $paymentHash;
    }

    public function setExpiryTime(int $expiryTime): void
    {
        $this->expiryTime = $expiryTime;
    }

    public function setExpiresAt(int $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getPaymentHash(): string
    {
        return $this->paymentHash;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMsatoshi(): int
    {
        return $this->msatoshi;
    }

    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getBolt11(): string
    {
        return $this->bolt11;
    }

    public function getExpiryTime(): int
    {
        return $this->expiryTime;
    }

    public function getMsatoshiReceived(): ?int
    {
        return $this->msatoshiReceived;
    }

    public function setMsatoshiReceived(int $msatoshiReceived): void
    {
        $this->msatoshiReceived = $msatoshiReceived;
    }

    public function getPayIndex(): ?int
    {
        return $this->payIndex;
    }

    public function setPayIndex(int $payIndex): void
    {
        $this->payIndex = $payIndex;
    }

    public function getPaidTimestamp(): int
    {
        return $this->paidTimestamp;
    }

    public function setPaidTimestamp(?int $paidTimestamp): void
    {
        $this->paidTimestamp = $paidTimestamp;
    }

    public function getPaidAt(): int
    {
        return $this->paidAt;
    }

    public function setPaidAt(?int $paidAt): void
    {
        $this->paidAt = $paidAt;
    }


}
<?php

namespace CLightning;

class Channel
{
    protected $source;
    protected $destination;
    protected $shortChannelId;
    protected $flags;
    protected $active;
    protected $public;
    protected $satoshis;
    protected $lastUpdate;
    protected $baseFeeMillisatoshi;
    protected $feePerMillionth;
    protected $delay;

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    public function getShortChannelId(): string
    {
        return $this->shortChannelId;
    }

    public function setShortChannelId(string $shortChannelId): void
    {
        $this->shortChannelId = $shortChannelId;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): void
    {
        $this->flags = $flags;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): void
    {
        $this->public = $public;
    }

    public function getSatoshis(): int
    {
        return $this->satoshis;
    }

    public function setSatoshis(int $satoshis): void
    {
        $this->satoshis = $satoshis;
    }

    public function getLastUpdate(): ?int
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(int $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }

    public function getBaseFeeMillisatoshi(): int
    {
        return $this->baseFeeMillisatoshi;
    }

    public function setBaseFeeMillisatoshi(int $baseFeeMillisatoshi): void
    {
        $this->baseFeeMillisatoshi = $baseFeeMillisatoshi;
    }

    public function getFeePerMillionth(): int
    {
        return $this->feePerMillionth;
    }

    public function setFeePerMillionth(int $feePerMillionth): void
    {
        $this->feePerMillionth = $feePerMillionth;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function setDelay(int $delay): void
    {
        $this->delay = $delay;
    }
}
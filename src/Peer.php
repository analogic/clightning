<?php

namespace CLightning;

class Peer
{
    protected $id;
    protected $connected;
    protected $channels;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function setConnected(bool $connected): void
    {
        $this->connected = $connected;
    }

    public function getChannels(): ?array
    {
        return $this->channels;
    }

    public function setChannels(array $channels): void
    {
        $this->channels = $channels;
    }


}
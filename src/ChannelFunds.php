<?php

namespace CLightning;

class ChannelFunds
{
    protected $peerId;
    protected $shortChannelId;
    protected $channelSat;
    protected $channelTotalSat;
    protected $fundingTxid;

    public function setPeerId(string $peerId): void
    {
        $this->peerId = $peerId;
    }

    public function setChannelSat(int $channelSat): void
    {
        $this->channelSat = $channelSat;
    }

    public function setChannelTotalSat(int $channelTotalSat): void
    {
        $this->channelTotalSat = $channelTotalSat;
    }

    public function setFundingTxid(string $fundingTxid): void
    {
        $this->fundingTxid = $fundingTxid;
    }

    public function getShortChannelId(): string
    {
        return $this->shortChannelId;
    }

    public function setShortChannelId(string $shortChannelId): void
    {
        $this->shortChannelId = $shortChannelId;
    }

    public function getFundingTxid(): ?string
    {
        return $this->fundingTxid;
    }

    public function getPeerId(): ?string
    {
        return $this->peerId;
    }

    public function getChannelSat(): ?int
    {
        return $this->channelSat;
    }

    public function getChannelTotalSat(): ?int
    {
        return $this->channelTotalSat;
    }

}
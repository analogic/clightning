<?php

namespace CLightning;

class Channel
{
    protected $from;
    protected $to;
    protected $baseFee;
    protected $proportionalFee;
    protected $shortChannelId;
    protected $flags;
    protected $lastUpdate;
    protected $delay;
    protected $satoshis;
    protected $active;
    protected $public;
    
    public function __construct(array $data)
    {
        $this->from = $data['from'];
        $this->to = $data['to'];
        $this->baseFee = $data['base_fee'];
        $this->proportionalFee = $data['proportional_fee'];
        $this->shortChannelId = $data['short_channel_id'];
        $this->flags = $data['flags'];
        $this->lastUpdate = $data['last_update'];
        $this->delay = $data['delay'];
        $this->satoshis = $data['satoshis'];
        $this->active = $data['active'];
        $this->public = $data['public'];
    }
    
    public function getFrom(): ?string
    {
        return $this->from;
    }
    
    public function getTo(): ?string
    {
        return $this->to;
    }
    
    public function getBaseFee(): ?int
    {
        return $this->baseFee;
    }
    
    public function getProportionalFee(): ?int
    {
        return $this->proportionalFee;
    }
    
    public function getShortChannelId(): ?string
    {
        return $this->shortChannelId;
    }
    
    public function getFlags(): ?int
    {
        return $this->flags;
    }
    
    public function getLastUpdate(): ?int
    {
        return $this->lastUpdate;
    }
    
    public function getDelay(): ?int
    {
        return $this->delay;
    }
    
    public function getSatoshis(): ?int
    {
        return $this->satoshis;
    }
    
    public function getActive(): ?bool
    {
        return $this->active;
    }
    
    public function getPublic(): ?bool
    {
        return $this->public;
    }

}
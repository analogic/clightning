<?php

namespace CLightning;

/*
 * { "id" : 6, "payment_hash" : "41254564f2b6780955bd512ef4706abba652408db1f9e418b221f025cc0d9bda", "destination" : "02d068a8135d9a4f62eb180336f1bc78b8f3516e7ef2de0bc81735610572921ba2", "msatoshi" : 100000, "msatoshi_sent" : 100283, "timestamp" : 1522756194, "created_at" : 1522756194, "status" : "complete", "payment_preimage" : "b18bc4c1c50114fbaa3096b912cb6adbee81533ace16cac45915ccf4b4c271fb", "getroute_tries" : 1, "sendpay_tries" : 1, "route" :
        [
                { "id" : "02d068a8135d9a4f62eb180336f1bc78b8f3516e7ef2de0bc81735610572921ba2", "channel" : "1284:1:0", "msatoshi" : 100283, "delay" : 6 } ], "failures" :
        [  ] }
 */

class Payment
{
    protected $paymentHash;
    protected $destination;
    protected $msatoshi;
    protected $msatoshiSent;
    protected $timestamp;
    protected $createdAt;
    protected $status;
    protected $paymentPreimage;
    protected $getrouteTries;
    protected $sendpayTries;
    protected $route;

    public function setPaymentHash(?string $v): Payment
    {
        $this->paymentHash = $v;
        return $this;
    }
    
    public function getPaymentHash(): ?string
    {
        return $this->paymentHash;
    }
    
    public function setDestination(?string $v): Payment
    {
        $this->destination = $v;
        return $this;
    }
    
    public function getDestination(): ?string
    {
        return $this->destination;
    }
    
    public function setMsatoshi(?int $v): Payment
    {
        $this->msatoshi = $v;
        return $this;
    }
    
    public function getMsatoshi(): ?int
    {
        return $this->msatoshi;
    }
    
    public function setTimestamp(?int $v): Payment
    {
        $this->timestamp = $v;
        return $this;
    }
    
    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }
    
    public function setStatus(?string $v): Payment
    {
        $this->status = $v;
        return $this;
    }
    
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getMsatoshiSent(): ?int
    {
        return $this->msatoshiSent;
    }

    public function setMsatoshiSent(int $msatoshiSent): void
    {
        $this->msatoshiSent = $msatoshiSent;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPaymentPreimage(): string
    {
        return $this->paymentPreimage;
    }

    public function setPaymentPreimage(string $paymentPreimage): void
    {
        $this->paymentPreimage = $paymentPreimage;
    }

    public function getGetrouteTries(): int
    {
        return $this->getrouteTries;
    }

    public function setGetrouteTries(int $getrouteTries): void
    {
        $this->getrouteTries = $getrouteTries;
    }

    public function getSendpayTries(): int
    {
        return $this->sendpayTries;
    }

    public function setSendpayTries(int $sendpayTries): void
    {
        $this->sendpayTries = $sendpayTries;
    }

    public function getRoute(): array
    {
        return $this->route;
    }

    public function setRoute(array $route): void
    {
        $this->route = $route;
    }


}
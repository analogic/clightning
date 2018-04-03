<?php

namespace CLightning;

class OutputFunds
{
    protected $txid;
    protected $output;
    protected $value;
    protected $status;

    public function setTxid(string $txid): void
    {
        $this->txid = $txid;
    }

    public function setOutput(int $output): void
    {
        $this->output = $output;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTxid(): ?string
    {
        return $this->txid;
    }
    
    public function getOutput(): ?int
    {
        return $this->output;
    }
    
    public function getValue(): ?int
    {
        return $this->value;
    }

}
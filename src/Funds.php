<?php

namespace CLightning;

class Funds
{
    protected $outputs = [];
    protected $channels = [];

    public function addOutput(OutputFunds $outputFunds)
    {
        $this->outputs[] = $outputFunds;
    }

    public function removeOutput(OutputFunds $outputFunds)
    {
    }

    public function addChannel(ChannelFunds $channelFunds)
    {
        $this->channels[] = $channelFunds;
    }

    public function removeChannel(OutputFunds $outputFunds)
    {
    }

     /** @return OutputFunds[] */
    public function getOutputs(): ?array
    {
        return $this->outputs;
    }
    
     /** @return ChannelFunds[] */
    public function getChannels(): ?array
    {
        return $this->channels;
    }

}
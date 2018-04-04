<?php

namespace CLightning;

/**
 * @method Channel current()
 * @method Channel offsetGet(string $index)
 */
class ChannelList extends \ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addChannel(Channel $channel)
    {
        $this->append($channel);
    }

    public function removeChannel(Channel $channel)
    {
    }

    public function getChannels(): array
    {
        return $this->getArrayCopy();
    }
}
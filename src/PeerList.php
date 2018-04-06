<?php

namespace CLightning;

/**
 * @method Peer current()
 * @method Peer offsetGet(string $index)
 */
class PeerList extends \ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addPeer(Peer $channel)
    {
        $this->append($channel);
    }

    public function removePeer(Peer $channel)
    {
    }

    public function getPeers(): array
    {
        return $this->getArrayCopy();
    }
}
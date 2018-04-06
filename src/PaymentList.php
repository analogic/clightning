<?php

namespace CLightning;

/**
 * @method Payment current()
 * @method Payment offsetGet(string $index)
 */
class PaymentList extends \ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addPayment(Payment $channel)
    {
        $this->append($channel);
    }

    public function removePayment(Payment $channel)
    {
    }

    public function getPayments(): array
    {
        return $this->getArrayCopy();
    }
}
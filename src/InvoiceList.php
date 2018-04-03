<?php

namespace CLightning;

/**
 * @method Invoice current()
 * @method Invoice offsetGet(string $index)
 */
class InvoiceList extends \ArrayIterator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addInvoice(Invoice $invoice)
    {
        $this->append($invoice);
    }

    public function removeInvoice(Invoice $invoice)
    {
    }

    public function getInvoices(): array
    {
        return $this->getArrayCopy();
    }
}
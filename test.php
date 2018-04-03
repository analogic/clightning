<?php
require_once 'vendor/autoload.php';

use Nbobtc\Bitcoind\Bitcoind;
use Nbobtc\Bitcoind\Client as BitcoinClient;

class CLightningClientTest extends \PHPUnit\Framework\TestCase
{
    private function getLclient1(): \CLightning\CLightning
    {
        return new \CLightning\CLightning('unix:///data/cln/lightning-1/rpc');
    }

    private function getLclient2(): \CLightning\CLightning
    {
        return new \CLightning\CLightning('unix:///data/cln/lightning-2/rpc');
    }

    private function getBclient1(): Bitcoind
    {
        return new Bitcoind(new BitcoinClient('http://bitcoinrpc:rpcpassword@'.getenv('SERVER').':18332'));
    }

    private function getBclient2(): Bitcoind
    {
        return new Bitcoind(new BitcoinClient('http://bitcoinrpc:rpcpassword@'.getenv('SERVER').':18334'));
    }

    public function testInvoice() {
        $c = $this->getLclient1();
        $id = uniqid();

        $expirationAt = time() + 100;
        $description = "My order $id test";
        $c->invoice(50, $id, $description, 100);

        $invoice = $c->listInvoices($id)[0];

        $this->assertEquals(50, $invoice->getMsatoshi());
        $this->assertEquals($id, $invoice->getLabel());
        $this->assertEquals($expirationAt, $invoice->getExpiresAt());

        $this->assertNotEmpty($invoice->getBolt11());
        $this->assertNotEmpty($invoice->getPaymentHash());
    }

    public function testNewAddr()
    {
        $c = $this->getLclient1();
        $this->assertNotEmpty($c->newaddr('p2sh-segwit'));
        $this->assertNotEmpty($c->newaddr('bech32'));
    }

    public function testListFunds()
    {
        $c = $this->getLclient1();
        $data = $c->listfunds();
        $this->assertTrue($data instanceof \CLightning\Funds);
    }

    public function testChannel()
    {
        $c1 = $this->getLclient1();
        $info1 = $c1->getinfo();

        $c2 = $this->getLclient2();
        $info2 = $c2->getinfo();

        $label = uniqid();
        $invoice = $this->getLclient2()->invoice(100*1000, $label, "moje platba 1");
        $this->assertNotEmpty($invoice->getBolt11());
        $payment = $this->getLclient1()->pay($invoice->getBolt11());

        $label = uniqid();
        $invoice = $this->getLclient1()->invoice(100*1000, $label, "moje platba 2");
        $this->assertNotEmpty($invoice->getBolt11());
        $payment = $this->getLclient2()->pay($invoice->getBolt11());

        $label = uniqid();
        $invoice = $this->getLclient2()->invoice(100*1000, $label, "moje platba 1");
        $this->assertNotEmpty($invoice->getBolt11());
        $payment = $this->getLclient1()->pay($invoice->getBolt11());

        $label = uniqid();
        $invoice = $this->getLclient1()->invoice(100*1000, $label, "moje platba 2");
        $this->assertNotEmpty($invoice->getBolt11());
        $payment = $this->getLclient2()->pay($invoice->getBolt11());
    }
}

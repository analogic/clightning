<?php

namespace CLightning;

use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Serializer;

class CLightning
{
    protected $dsn;

    /** @var Serializer */
    protected $serializer;
    /** @var JsonRPCEncoder */
    protected $encoder;

    protected $logger;

    public $timeout = 5;

    public function __construct(string $dsn, ?InOutLogger $logger)
    {
        $this->dsn = $dsn;
        $this->logger = $logger;
    }

    protected function initSerializer()
    {
        $this->encoder = new JsonRPCEncoder();
        $this->serializer = new Serializer(
            [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter(), null, new ReflectionExtractor()), new ArrayDenormalizer()],
            [$this->encoder]
        );
    }

    public function execute(string $method, array $params = [], ?string $type = null)
    {
        if (!$this->serializer) {
            $this->initSerializer();
        }

        $fp = stream_socket_client($this->dsn, $errno, $errstr, $this->timeout);
        if ($this->timeout) {
            stream_set_timeout($fp, $this->timeout);
        }

        if (!$fp) {
            throw new \RuntimeException("$errstr ($errno)");
        } else {

            $json = json_encode(array('method' => $method, 'params' => $params, 'id' => 0));
            if ($this->logger) $this->logger->out($json);
            fwrite($fp, $json);
            $buffer = '';

            while (!feof($fp)) {
                $data = fgets($fp, 1024);
                if ($this->logger) $this->logger->in($data);

                $buffer .= $data;
                if (strlen($data) === 0) {
                    throw new \RuntimeException('Connection to RPC server lost.');
                }
                try {
                    if ($type) {
                        $object = $this->serializer->deserialize($buffer, $type, 'json');
                    } else {
                        $object = $this->encoder->decode($buffer, 'json');
                    }

                    fclose($fp);
                    return $object;
                } catch (NotEncodableValueException $e) {
                    continue;
                }
            }
        }
    }

    /**
     * @param int|string $milliSatoshi string "any", which creates an invoice
    that can be paid with any amount or exact amount of satoshi*1000
     * @param string $label must be a unique string; it is never revealed to other nodes on
    the lightning network, but it can be used to query the status of this invoice.
     * @param string $description is a short description of purpose of payment,
    e.g. '1 cup of coffee'. This value is encoded into the BOLT11 invoice
    and is viewable by any node you send this invoice to. It must be
    UTF-8
     * @param int|null $expiry The 'expiry' is optionally the number of seconds the invoice is valid for.
    If no value is provided the default of 3600 (1 Hour) is used.
     * @throws
     * @return Invoice
     */
    public function invoice($milliSatoshi, string $label, string $description, int $expiry = 3600): Invoice
    {
        return $this->execute('invoice', [
            'msatoshi' => $milliSatoshi,
            'label' => $label,
            'description' => $description,
            'expiry' => $expiry
        ], Invoice::class);
    }

    /**
     * @return Invoice[]
     * @throws
     */
    public function listInvoices(?string $label = null): InvoiceList
    {
        $args = [];

        if ($label !== null) $args['label'] = $label;

        return $this->execute('listinvoices', $args, InvoiceList::class);
    }


    /**
     * Send to {destination} address {satoshi} (or 'all') amount via Bitcoin transaction
     */
    public function withdraw(string $destination, $satoshi)
    {
        return $this->execute('withdraw', ['destination' => $destination, 'satoshi' => $satoshi]);
    }

    /**
     * Get a new {bech32, p2sh-segwit} address to fund a channel
     */
    public function newaddr(string $type = 'p2sh-segwit'): string
    {
        return $this->execute('newaddr', [$type])['address'];
    }

    /**
     * Show available funds from the internal wallet
     */
    public function listFunds(): Funds
    {
        return $this->execute('listfunds', [],Funds::class);
    }

    /**
     * Connect to {id} at {host} (which can end in ':port' if not default). {id} can also be of the form id@host
     */
    public function connect(string $id, string $host)
    {
        return $this->execute('connect', ['id' => $id, 'host' => $host]);
    }

    /**
     * Show node {id} (or all, if no {id}), in our local network view
     */
    public function listnodes(string $id = null): array
    {
        $args = [];

        if ($id !== null) $args['id'] = $id;

        return $this->execute('listnodes', $args)['nodes'];
    }

    /**
     * Show route to {id} for {msatoshi}, using {riskfactor} and optional {cltv} (default 9). If specified search from {fromid} otherwise use this node as source. Randomize the route with up to {fuzzpercent} (0.0 -> 100.0, default 5.0) using {seed} as an arbitrary-size string seed.
     */
    public function getroute()
    {
        return $this->execute('getroute', []);
    }

    /**
     * Show channel {short_channel_id} (or all known channels, if no {short_channel_id})
     */
    public function listChannels(?string $short_channel_id = null)
    {
        $args = [];

        if ($short_channel_id !== null) $args['short_channel_id'] = $short_channel_id;


        return $this->execute('listchannels', $args, ChannelList::class);
    }

    /**
     * Delete unpaid invoice {label} with {status}
     */
    public function delinvoice()
    {
        return $this->execute('delinvoice', []);
    }

    /**
     * Wait for the next invoice to be paid, after {lastpay_index} (if supplied)
     */
    public function waitanyinvoice(?int $last_index = 0): ?Invoice
    {
        $args = [];

        if ($last_index !== null) $args['lastpay_index'] = $last_index;

        return $this->execute('waitanyinvoice', $args, Invoice::class);
    }

    /**
     * Wait for an incoming payment matching the invoice with {label}, or if the invoice expires
     */
    public function waitinvoice()
    {
        return $this->execute('waitinvoice', []);
    }

    /**
     * Decode {bolt11}, using {description} if necessary
     */
    public function decodepay(?string $bolt11, ?string $description = null)
    {
        $args = [];

        if ($bolt11 !== null) $args['bolt11'] = $bolt11;
        if ($description !== null) $args['description'] = $description;

        return $this->execute('decodepay', $description);
    }

    /**
     * List available commands, or give verbose help on one command.
     */
    public function help()
    {
        return $this->execute('help', []);
    }

    /**
     * Shut down the lightningd process
     */
    public function stop()
    {
        return $this->execute('stop', []);
    }

    /**
     * Show information about this node
     */
    public function getinfo()
    {
        return $this->execute('getinfo', []);
    }

    /**
     * Show logs, with optional log {level} (info|unusual|debug|io)
     */
    public function getlog()
    {
        return $this->execute('getlog', []);
    }

    /**
     * Fund channel with {id} using {satoshi} satoshis
     */
    public function fundchannel(string $id, int $satoshi)
    {
        return $this->execute('fundchannel', ['id' => $id, 'satoshi' => $satoshi]);
    }

    /**
     * List all configuration options, or with [config], just that one.
     */
    public function listconfigs()
    {
        return $this->execute('listconfigs', []);
    }

    /**
     * Send along {route} in return for preimage of {payment_hash}
     */
    public function sendpay()
    {
        return $this->execute('sendpay', []);
    }

    /**
     * Wait for payment attempt on {payment_hash} to succeed or fail, but only up to {timeout} seconds.
     */
    public function waitsendpay()
    {
        return $this->execute('waitsendpay', []);
    }

    /**
     * Show outgoing payments
     */
    public function listpayments()
    {
        return $this->execute('listpayments', [], PaymentList::class);
    }

    /**
     * Send payment specified by {bolt11} with optional {msatoshi} (if and only if {bolt11} does not have amount), {description} (required if {bolt11} uses description hash), {riskfactor} (default 1.0), and {maxfeepercent} (default 0.5) the maximum acceptable fee as a percentage (e.g. 0.5 => 0.5%)
     */
    public function pay(string $bolt11, ?int $msatoshi = null, ?string $description = null, ?float $riskfactor = 1.0, float $maxfeepercent = 0.5): Payment
    {
        $args = [];

        $args['bolt11'] = $bolt11;
        if ($msatoshi !== null) $args['msatoshi'] = $msatoshi;
        if ($description !== null) $args['description'] = $description;
        if ($riskfactor !== null) $args['riskfactor'] = $riskfactor;
        if ($maxfeepercent !== null) $args['maxfeepercent'] = $maxfeepercent;

        return $this->execute('pay', $args, Payment::class);
    }

    /**
     * Show current peers, if {level} is set, include logs for {id}
     */
    public function listPeers(?string $level = null, ?string $id = null)
    {
        $args = [];

        if ($level !== null) $args['level'] = $level;
        if ($id !== null) $args['id'] = $id;

        return $this->execute('listpeers', $args, PeerList::class);
    }

    /**
     * Close the channel with peer {id}
     */
    public function close(string $id)
    {
        return $this->execute('close', ['id' => $id]);
    }

    /**
     * Disconnect from {id} that has previously been connected to using connect
     */
    public function disconnect()
    {
        return $this->execute('disconnect', []);
    }

    /**
     * Show SHA256 of {secret}
     */
    public function dev_rhash()
    {
        return $this->execute('dev-rhash', []);
    }

    /**
     * Crash lightningd by calling fatal()
     */
    public function dev_crash()
    {
        return $this->execute('dev-crash', []);
    }

    /**
     * Show current block height
     */
    public function dev_blockheight()
    {
        return $this->execute('dev-blockheight', []);
    }

    /**
     * Set feerate in satoshi-per-kw for {immediate}, {normal} and {slow} (each is optional, when set, separate by spaces) and show the value of those three feerates
     */
    public function dev_setfees()
    {
        return $this->execute('dev-setfees', []);
    }

    /**
     * Sign and show the last commitment transaction with peer {id}
     */
    public function dev_sign_last_tx()
    {
        return $this->execute('dev-sign-last-tx', []);
    }

    /**
     * Fail with peer {id}
     */
    public function dev_fail()
    {
        return $this->execute('dev-fail', []);
    }

    /**
     * Re-enable the commit timer on peer {id}
     */
    public function dev_reenable_commit()
    {
        return $this->execute('dev-reenable-commit', []);
    }

    /**
     * Forget the channel with peer {id}, ignore UTXO check with {force}='true'.
     */
    public function dev_forget_channel()
    {
        return $this->execute('dev-forget-channel', []);
    }

    /**
     * Send {peerid} a ping of length {len} asking for {pongbytes}
     */
    public function dev_ping()
    {
        return $this->execute('dev-ping', []);
    }

    /**
     * Show memory objects currently in use
     */
    public function dev_memdump()
    {
        return $this->execute('dev-memdump', []);
    }

    /**
     * Show unreferenced memory objects
     */
    public function dev_memleak()
    {
        return $this->execute('dev-memleak', []);
    }

    /**
     * Show addresses list up to derivation {index} (default is the last bip32 index)
     */
    public function dev_listaddrs()
    {
        return $this->execute('dev-listaddrs', []);
    }

    /**
     * Synchronize the state of our funds with bitcoind
     */
    public function dev_rescan_outputs()
    {
        return $this->execute('dev-rescan-outputs', []);
    }
}
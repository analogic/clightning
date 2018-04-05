<?php
require_once 'vendor/autoload.php';

$cl1 = new \CLightning\CLightning('unix:///data/cln/lightning-1/rpc');
$cl2 = new \CLightning\CLightning('unix:///data/cln/lightning-2/rpc');

var_dump($cl1->listFunds());
var_dump($cl2->listFunds());

$info1 = $cl1->getinfo();
var_dump($info1);

$info2 = $cl2->getinfo();
var_dump($info2);


// connect lightnings nodes together
$result = $cl2->connect($info1['id'], 'localhost:'.$info1['port']);
var_dump($result);

// generate new address for lightning funds
$address = $cl1->newaddr();
var_dump($result);

// send some funds to lightning node
$btcd = new \Nbobtc\Bitcoind\Bitcoind(new \Nbobtc\Bitcoind\Client('http://bitcoinrpc:rpcpassword@'.getenv('SERVER').':18332'));
$btcd->sendtoaddress($address, 0.1);

// sleeping to confirmation of funds
sleep(15);

// funding channel with node number 2
$result = $cl1->fundchannel($info2['id'], 10000);
var_dump($result);

var_dump($cl1->listPeers());
var_dump($cl1->listFunds());
var_dump($cl1->listChannels());
<?php

require_once __DIR__ . '/vendor/autoload.php';

$uri = (new \Http\Message\UriFactory\GuzzleUriFactory())->createUri('http://127.0.0.1:32768/wd/hub');
$client =
    new \Http\Client\Common\PluginClient(new \Http\Adapter\React\Client(), [
        new \Http\Client\Common\Plugin\AddHostPlugin($uri),
        new \Http\Client\Common\Plugin\BaseUriPlugin($uri),
        new \Http\Client\Common\Plugin\HeaderDefaultsPlugin([
            'Content-Type' => 'application/json;charset=UTF-8',
            'Accept' => 'application/json',
        ]),
        new \Http\Client\Common\Plugin\ContentLengthPlugin(),
    ]);

$requestFactory = new \Http\Message\MessageFactory\GuzzleMessageFactory();
$request = $requestFactory->createRequest('POST', '/session', [], '{"desiredCapabilities": { "browserName": "chrome"}}');

$response = $client->sendRequest($request);

var_dump(json_decode((string) $response->getBody()));



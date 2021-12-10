<?php declare(strict_types=1);

namespace Seven\Nette\Http;

use Contributte\Guzzlette\ClientFactory;
use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GuzzletteClient implements IHttpClient {

	/** @var Client */
	private $client;

	public function __construct(ClientFactory $clientFactory) {
		$this->client = $clientFactory->createClient([
			'http_errors' => false,
			'timeout' => 30,
		]);
	}

	public function sendRequest(RequestInterface $request): ResponseInterface {
		return $this->client->send($request);
	}

}

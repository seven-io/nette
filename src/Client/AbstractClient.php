<?php declare(strict_types=1);

namespace Seven\Nette\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Seven\Nette\Config;
use Seven\Nette\Exception\ClientException;
use Seven\Nette\Http\IHttpClient;

abstract class AbstractClient {

	protected const BASE_URL = 'https://gateway.sms77.io/api/';

	/** @var Config */
	private $config;

	/** @var IHttpClient */
	private $client;

	public function __construct(Config $config, IHttpClient $client) {
		$this->client = $client;
		$this->config = $config;
	}

	protected function buildURI(): string {
		return self::BASE_URL . $this->getEndpoint();
	}

	abstract function getEndpoint(): string;

	protected function doRequest(RequestInterface $request): ResponseInterface {
		return $this->client->sendRequest(
			$request
				->withHeader('X-Api-Key', $this->config->getApiKey())
				->withHeader('SentWith', 'nette')
		);
	}

	protected function assertResponse(ResponseInterface $response, int $code = 200): void {
		if ($response->getStatusCode() !== $code) {
			throw new ClientException($response->getBody()->getContents(), $response->getStatusCode());
		}
	}

}

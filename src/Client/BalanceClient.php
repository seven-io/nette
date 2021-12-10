<?php declare(strict_types=1);

namespace Seven\Nette\Client;

use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;

class BalanceClient extends AbstractClient {
	public function get(): float {
		$response = $this->doRequest(new Request('GET', $this->buildURI()));
		$this->assertResponse($response);

		return Json::decode($response->getBody()->getContents());
	}

	function getEndpoint(): string {
		return 'balance';
	}

}

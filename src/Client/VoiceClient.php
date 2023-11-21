<?php declare(strict_types=1);

namespace Seven\Nette\Client;

use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Seven\Nette\Entity\VoiceMessage;

class VoiceClient extends AbstractClient {
	function getEndpoint(): string {
		return 'voice';
	}

	public function test(VoiceMessage $message): object {
		return $this->send($message);
	}

	/**
	 * @param VoiceMessage $message
	 * @return object
	 * @throws JsonException
	 */
	public function send(VoiceMessage $message): object {
		$body = Json::encode($message->toArray());

		$response = $this->doRequest(
			new Request('POST', $this->buildURI(), ['Content-Type' => 'application/json'], $body)
		);

		$this->assertResponse($response);

		return Json::decode($response->getBody()->getContents());
	}
}

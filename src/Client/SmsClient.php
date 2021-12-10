<?php declare(strict_types=1);

namespace Seven\Nette\Client;

use GuzzleHttp\Psr7\Request;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Seven\Nette\Entity\SmsMessage;

class SmsClient extends AbstractClient {
	function getEndpoint(): string {
		return 'sms';
	}

	public function test(SmsMessage $message): object {
		$message->setDebug(true);

		return $this->send($message);
	}

	/**
	 * @param SmsMessage $message
	 * @return object
	 * @throws JsonException
	 */
	public function send(SmsMessage $message): object {
		$body = Json::encode($message->toArray());

		$response = $this->doRequest(
			new Request('POST', $this->buildURI(), ['Content-Type' => 'application/json'], $body)
		);

		$this->assertResponse($response);

		return Json::decode($response->getBody()->getContents());
	}

	/**
	 * @param int[] | int $ids
	 * @return array
	 * @throws JsonException
	 */
	public function status($ids): array {
		if (!is_array($ids)) $ids = [$ids];
		$ids = implode(',', $ids);

		$url = sprintf('%s/%s?msg_id=%s&json=1', self::BASE_URL, 'status', $ids);

		$response = $this->doRequest(new Request('GET', $url));

		$this->assertResponse($response);

		return Json::decode($response->getBody()->getContents());
	}
}

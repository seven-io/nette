<?php declare(strict_types=1);

namespace Seven\Nette;

class Config {

	/** @var string */
	private $apiKey;

	public function __construct(string $apiKey) {
		$this->apiKey = $apiKey;
	}

	public function getApiKey(): string {
		return $this->apiKey;
	}

}

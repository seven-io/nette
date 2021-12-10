<?php declare(strict_types=1);

namespace Seven\Nette\Entity;

class VoiceMessage {

	/** @var bool $debug */
	protected $debug = false;

	/** @var string|null */
	protected $from;

	/** @var string $message */
	protected $message;

	/** @var string $recipient */
	protected $recipient;

	/** @var bool $xml */
	protected $xml = false;

	public function __construct(string $message, string $recipient) {
		$this->message = $message;
		$this->recipient = $recipient;
	}

	public function getMessage(): string {
		return $this->message;
	}

	public function getRecipient(): string {
		return $this->recipient;
	}

	public function getDebug(): bool {
		return $this->debug;
	}

	public function setDebug(bool $debug): void {
		$this->debug = $debug;
	}

	public function getXml(): bool {
		return $this->xml;
	}

	public function setXml(bool $xml): void {
		$this->xml = $xml;
	}

	public function getFrom(): ?string {
		return $this->from;
	}

	public function setFrom(?string $from): void {
		$this->from = $from;
	}

	/**
	 * @return array
	 */
	public function toArray(): array {
		$arr = [
			'json' => 1,
			'text' => $this->message,
			'to' => $this->recipient,
		];

		if ($this->debug) $arr['debug'] = 1;

		if ($this->xml) $arr['xml'] = 1;

		if ($this->from !== null) $arr['from'] = $this->from;

		return $arr;
	}

}

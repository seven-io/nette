<?php declare(strict_types=1);

namespace Seven\Nette\Entity;

use DateTimeImmutable;
use DateTimeInterface;

class SmsMessage {

	/** @var DateTimeImmutable|null */
	protected $delay;

	/** @var bool */
	protected $flash = false;

	/** @var string|null */
	protected $foreignId;

	/** @var string|null */
	protected $from;

	/** @var string|null */
	protected $label;

	/** @var string */
	protected $message;

	/** @var bool */
	protected $noReload = false;

	/** @var bool */
	protected $performanceTracking = false;

	/** @var array */
	protected $recipients;

	public function __construct(string $message, array $recipients) {
		$this->message = $message;
		$this->recipients = $recipients;
	}

	public function getMessage(): string {
		return $this->message;
	}

	/**
	 * @return array
	 */
	public function getRecipients(): array {
		return $this->recipients;
	}

	public function getDelay(): ?DateTimeImmutable {
		return $this->delay;
	}

	public function setDelay(?DateTimeImmutable $delay): void {
		$this->delay = $delay;
	}

	public function getFlash(): bool {
		return $this->flash;
	}

	public function setFlash(bool $flash): void {
		$this->flash = $flash;
	}

	public function getForeignId(): ?string {
		return $this->foreignId;
	}

	public function setForeignId(?string $foreignId): void {
		$this->foreignId = $foreignId;
	}

	public function getFrom(): ?string {
		return $this->from;
	}

	public function setFrom(?string $from): void {
		$this->from = $from;
	}

	public function getLabel(): ?string {
		return $this->label;
	}

	public function setLabel(?string $label): void {
		$this->label = $label;
	}

	public function getNoReload(): bool {
		return $this->noReload;
	}

	public function setNoReload(bool $noReload): void {
		$this->noReload = $noReload;
	}

	public function getPerformanceTracking(): bool {
		return $this->performanceTracking;
	}

	public function setPerformanceTracking(bool $performanceTracking): void {
		$this->performanceTracking = $performanceTracking;
	}

	/**
	 * @return array
	 */
	public function toArray(): array {
		$arr = [
			'json' => 1,
			'text' => $this->message,
			'to' => implode(',', $this->recipients),
		];

		if ($this->delay !== null) {
			$arr['delay'] = date('Y-m-d H:i:s',
				strtotime($this->delay->format(DateTimeInterface::ATOM)));
		}

		if ($this->flash) {
			$arr['flash'] = 1;
		}

		if ($this->foreignId !== null) {
			$arr['foreign_id'] = $this->foreignId;
		}

		if ($this->from !== null) {
			$arr['from'] = $this->from;
		}

		if ($this->label !== null) {
			$arr['label'] = $this->label;
		}

		if ($this->noReload) {
			$arr['no_reload'] = 1;
		}

		if ($this->performanceTracking) {
			$arr['performance_tracking'] = 1;
		}

		return $arr;
	}

}

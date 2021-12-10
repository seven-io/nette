```php
<?php

namespace App;

use Seven\Nette\Client\SmsClient;
use Seven\Nette\Entity\SmsMessage;
use Seven\Nette\Exception\ClientException;

final class SendPaymentsControl extends BaseControl
{

	/** @var SmsClient */
	private $smsClient;

	public function __construct(SmsClient $smsClient)
	{
		$this->smsClient = $smsClient;
	}

	public function handleSend(): void
	{
		$result = null;
		$msg = new SmsMessage('Message body', ['+420711555444'], 1);

		try {
			$result = $this->smsClient->send($msg);
		} catch (ClientException $e) {
			$e->getCode(); // Response status
			$e->getMessage(); // Response body
			exit;
		}

		$this->saveSentMessage($result->parsedId, $msg); // Process successful result as you like
	}

}
```

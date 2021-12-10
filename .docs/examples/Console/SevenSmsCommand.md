This example demonstrates how to send SMS via a console command.

```php
<?php

namespace App\Console;

use Seven\Nette\Client\SmsClient;
use Seven\Nette\Entity\SmsMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php bin/console seven:sms "Hello there" +491771783130 +4943130149270
final class SevenSmsCommand extends Command {
	/** @var SmsClient $smsClient */
	private $smsClient;

	/**
	 * Pass dependencies with constructor injection
	 */
	public function __construct(SmsClient $smsClient) {
		parent::__construct(); // don't forget parent call as we extend from Command

		$this->smsClient = $smsClient;

	}

	protected function configure(): void {
		$this->setName('seven:sms')
			->setDescription('Send SMS via seven')
            ->addArgument('text', InputArgument::REQUIRED, 'The SMS text to send')
            ->addArgument('to', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The recipient\'s phone number - separate multiple numbers with a space');
	}

	/**
	 * Don't forget to return 0 for success or non-zero for error
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$to = $input->getArgument('to');
		$text = $input->getArgument('text');

		$output->writeln(sprintf('Sending SMS to %s…', implode(',', $to)));

		$msg = new SmsMessage($text, $to);

		try {
			$this->smsClient->send($msg);
			$output->writeln('<success>✔ SMS successfully sent</success>');
			return 0;
		} catch (\Exception $e) {
			$output->writeln(sprintf('<error>❌ Error occurred: </error>', $e->getMessage()));
			return 1;
		}
	}
}
```

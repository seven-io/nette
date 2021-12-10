This example demonstrates how to retrieve SMS status by its ID.

```php
<?php

namespace App\Console;

use Seven\Nette\Client\SmsClient;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php bin/console seven:sms:status 12345 67890
final class SevenSmsStatusCommand extends Command {
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
		$this->setName('seven:sms:status')
			->setDescription('Look up SMS status by seven SMS ID')
            ->addArgument(
                'msg_id',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'The SMS ID for looking up - separate multiple numbers with a space'
            )
        ;
	}

	/**
	 * Don't forget to return 0 for success or non-zero for error
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$msgIds = $input->getArgument('msg_id');

		$output->writeln(sprintf('Looking up SMS IDs %s…', implode(',', $msgIds)));

		try {
			$statuses = $this->smsClient->status($msgIds);
			$output->writeln('<success>✔ Successfully looked up SMS status</success>');
            foreach ($statuses as $status) {
                $output->writeln(Json::encode($status));
            }
			return 0;
		} catch (\Exception $e) {
			$output->writeln(sprintf('<error>❌ Error occurred: </error>', $e->getMessage()));
			return 1;
		}
	}
}
```

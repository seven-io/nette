This example demonstrates how to retrieve the account balance via a console command.

```php
<?php

namespace App\Console;

use Seven\Nette\Client\BalanceClient;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php bin/console seven:balance
final class SevenBalanceCommand extends Command {
	/** @var BalanceClient $balanceClient */
	private $balanceClient;

	/**
	 * Pass dependencies with constructor injection
	 */
	public function __construct(BalanceClient $balanceClient) {
		parent::__construct(); // don't forget parent call as we extend from Command

		$this->balanceClient = $balanceClient;
	}

	protected function configure(): void {
		$this->setName('seven:balance')
			->setDescription('Retrieve seven account balance')
        ;
	}

	/**
	 * Don't forget to return 0 for success or non-zero for error
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$output->writeln('Retrieving seven account balance…');

		try {
			$balance = $this->balanceClient->get();
			$output->writeln('<success>✔ Successfully retrieved seven account balance</success>');
            $output->writeln(Json::encode($balance));
            return 0;
		} catch (\Exception $e) {
			$output->writeln(sprintf('<error>❌ Error occurred: </error>', $e->getMessage()));
			return 1;
		}
	}
}
```

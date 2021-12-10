This example demonstrates how to make a text-to-speech call.

```php
<?php

namespace App\Console;

use Seven\Nette\Client\VoiceClient;
use Seven\Nette\Entity\VoiceMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// php bin/console seven:voice "Hello there" +491771783130
final class SevenVoiceCommand extends Command {
	/** @var VoiceClient $voiceClient */
	private $voiceClient;

	/**
	 * Pass dependencies with constructor injection
	 */
	public function __construct(VoiceClient $voiceClient) {
		parent::__construct(); // don't forget parent call as we extend from Command

		$this->voiceClient = $voiceClient;

	}

	protected function configure(): void {
		$this->setName('seven:voice')
			->setDescription('Make a text-to-speech call via seven')
            ->addArgument('text', InputArgument::REQUIRED, 'The message to convert to speech')
            ->addArgument('to', InputArgument::REQUIRED, 'The recipient\'s phone number');
	}

	/**
	 * Don't forget to return 0 for success or non-zero for error
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$to = $input->getArgument('to');
		$text = $input->getArgument('text');

		$output->writeln(sprintf('Making text-to-speech call to %s…', $to));

		$msg = new VoiceMessage($text, $to);

		try {
			$this->voiceClient->send($msg);
			$output->writeln('<success>✔ text-to-speech call successfully issued</success>');
			return 0;
		} catch (\Exception $e) {
			$output->writeln(sprintf('<error>❌ Error occurred: </error>', $e->getMessage()));
			return 1;
		}
	}
}
```

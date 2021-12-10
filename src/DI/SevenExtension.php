<?php declare(strict_types=1);

namespace Seven\Nette\DI;

use Nette;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Seven\Nette\Client\BalanceClient;
use Seven\Nette\Client\SmsClient;
use Seven\Nette\Client\VoiceClient;
use Seven\Nette\Config;
use Seven\Nette\Http\GuzzletteClient;
use stdClass;

/**
 * @property-read stdClass $config
 */
class SevenExtension extends CompilerExtension {

	public function getConfigSchema(): Nette\Schema\Schema {
		return Expect::structure([
			'apiKey' => Expect::string()->required(),
			'httpClient' => Expect::anyOf(
				Expect::string(),
				Expect::array(),
				Expect::type(Statement::class)
			),
		]);
	}

	public function loadConfiguration(): void {
		$config = $this->config;
		$builder = $this->getContainerBuilder();

		$configStatement = new Statement(Config::class, [
			$config->apiKey,
		]);

		$this->compiler->loadDefinitionsFromConfig([
			$this->prefix('httpClient') => $config->httpClient ?? GuzzletteClient::class,
		]);

		$builder->addDefinition($this->prefix('sms'))
			->setFactory(SmsClient::class, [$configStatement]);

		$builder->addDefinition($this->prefix('balance'))
			->setFactory(BalanceClient::class, [$configStatement]);

		$builder->addDefinition($this->prefix('voice'))
			->setFactory(VoiceClient::class, [$configStatement]);
	}

}

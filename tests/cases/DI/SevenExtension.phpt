<?php declare(strict_types = 1);

use Seven\Nette\Client\BalanceClient;
use Seven\Nette\Client\SmsClient;
use Seven\Nette\Client\VoiceClient;
use Seven\Nette\DI\SevenExtension;
use Seven\Nette\Http\GuzzletteClient;
use Contributte\Guzzlette\DI\GuzzleExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

// Test if Extension and Config is created
test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->addExtension('guz', new GuzzleExtension());
		$compiler->addExtension('seven', new SevenExtension())
			->addConfig([
				'seven' => [
					'apiKey' => 'X',
				],
			]);
	}, 1);

	/** @var Container $container */
	$container = new $class();

	// Service created
	Assert::type(SmsClient::class, $container->getService('seven.sms'));
	Assert::type(BalanceClient::class, $container->getService('seven.balance'));
});

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->addExtension('guz', new GuzzleExtension());
		$compiler->addExtension('seven', new SevenExtension())
			->addConfig([
				'seven' => [
					'apiKey' => 'X',
					'httpClient' => GuzzletteClient::class,
				],
			]);
	}, 1);

	/** @var Container $container */
	$container = new $class();

	// Service created
	Assert::type(SmsClient::class, $container->getService('seven.sms'));
	Assert::type(VoiceClient::class, $container->getService('seven.voice'));
	Assert::type(BalanceClient::class, $container->getService('seven.balance'));
});

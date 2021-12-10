# seven.io API Integration

## Content

- [Requirements - what do you need?](#requirements)
- [Installation - how to register an extension?](#installation)
- [Usage - how to use it?](#usage)

## Requirements

Create an account at [seven.io](https://www.seven.io) and copy
an [API key](https://help.sms77.io/en/api-key-access) from
your [developer dashboard](https://app.seven.io/developer).

If using the default HTTP client, you need to install and
register the [guzzlette](https://github.com/contributte/guzzlette/) extension.

## Installation

```neon
extensions:
	guzzle: Contributte\Guzzlette\DI\GuzzleExtension # optional for the default HTTP client
	seven: Seven\Nette\DI\SevenExtension

seven:
	apiKey: aBcDeFgHiJkLmNoPqRsTiu1235773462 # required

	httpClient: # optional
```

## Usage

We prepared the following clients to cover the most commonly used endpoints:

- [SmsClient](https://www.sms77.io/en/docs/gateway/http-api/sms-dispatch/)
- [BalanceClient](https://www.sms77.io/en/docs/gateway/http-api/credit-balance/)
- [VoiceClient](https://www.sms77.io/en/docs/gateway/http-api/voice/)

### BalanceClient

* `get()` - [Retrieve account balance](https://docs.seven.io/gateway/http-api/credit-balance)

### SmsClient

* `send(Seven\Nette\Entity\SmsMessage)`
  - [Sends message](https://docs.seven.io/gateway/http-api/sms-dispatch)
* `test(Seven\Nette\Entity\SmsMessage)`
  - [Test creating message without sending](https://docs.seven.io/gateway/http-api/sms-dispatch)
* `status(string $id)`
  - [Retrieve SMS status](https://docs.seven.io/gateway/http-api/status-reports)

### VoiceClient - for making text-to-speech calls

* `send(Seven\Nette\Entity\VoiceMessage)`
  - [Sends message](https://docs.seven.io/gateway/http-api/sms-dispatch)
* `test(Seven\Nette\Entity\VoiceMessage)`
  - [Test creating message without sending](https://docs.seven.io/gateway/http-api/sms-dispatch)

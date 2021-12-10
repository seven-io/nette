<?php declare(strict_types=1);

namespace Seven\Nette\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface IHttpClient {

	public function sendRequest(RequestInterface $request): ResponseInterface;

}

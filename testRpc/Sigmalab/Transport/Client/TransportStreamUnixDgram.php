<?php


namespace Sigmalab\AdoDatabase\TransportClient;


use Exception;

/**
 * Class TransportStreamUnixDgram
 * @package Sigmalab\AdoDatabase\TransportClient
 *
 * FIXME: Experiment - does not work. Remove in stable
 */
class TransportStreamUnixDgram implements ITransport
{
	private $socket;

	/** server side socket filename is known apriori
	 * @var string
	 */
	private string $serverPipe = "/tmp/server.sock";
	private string $clientPipe = "/tmp/client.sock";

	function __construct(string $serverSockPath, string $clientSockPath)
	{
		$this->serverPipe = $serverSockPath;
		$this->clientPipe = $clientSockPath;
	}

	function start()
	{
		$this->socket = stream_socket_client("udg://{$this->serverPipe}", $errno, $errstr);
		//stream_set_blocking($this->socket, false);
		if (!$this->socket) {
			throw new Exception("Error: $errno - $errstr");
		}
	}

	function call(string $message): string
	{
		$server = "{$this->serverPipe}";
		stream_socket_sendto($this->socket, $message, 0);

		$buffer = stream_socket_recvfrom($this->socket, 65536, 0);
		return $buffer;
	}

	function dispose()
	{
		fclose($this->socket);
	}
}
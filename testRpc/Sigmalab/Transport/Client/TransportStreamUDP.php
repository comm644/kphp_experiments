<?php


namespace Sigmalab\AdoDatabase\TransportClient;
use Exception;



/**
 * Class TransportStreamUDP
 * @package Sigmalab\AdoDatabase\Transport\Client
 */
class TransportStreamUDP implements ITransport
{
	private $soket;
	/** server side socket filename is known apriori
	 * @var string
	 */
	private string $serverAddress = "127.0.0.1";
	private int $serverPort = 43026;
	private $socket;

	function __construct(string $serverAddress, int $serverPort)
	{
		$this->serverAddress = $serverAddress;
		$this->serverPort = $serverPort;

	}

	function start()
	{
		$this->socket = stream_socket_client("udp://{$this->serverAddress}:{$this->serverPort}", $errno, $errstr);
		//stream_set_blocking($this->socket, false);
		if (!$this->socket) {
			throw new Exception("Error: $errno - $errstr");
		}
	}


	function call(string $message): string
	{
//		fwrite($this->socket, $message);
//		fflush($this->socket);
//		$buffer = fread($this->socket, 65536);

		$server = "{$this->serverAddress}:{$this->serverPort}";
		stream_socket_sendto($this->socket, $message, 0, $server);

		$buffer = stream_socket_recvfrom($this->socket, 65536, 0);

		return $buffer;
	}

	function dispose()
	{
		fclose($this->socket);
	}

}
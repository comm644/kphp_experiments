<?php


namespace Sigmalab\AdoDatabase\TransportClient;


use Exception;

class TransportSocketUnixDgram implements ITransport
{
	private $soket;
	/** server side socket filename is known apriori
	 * @var string
	 */
	private string $server_side_sock = "/tmp/server.sock";
	private string $client_side_sock = "/tmp/client.sock";

	function __construct(string $serverSockPath, string $clientSockPath)
	{
		$this->server_side_sock = $serverSockPath;
		$this->client_side_sock = $clientSockPath;
	}

	function start()
	{
		if (!extension_loaded('sockets')) {
			throw new Exception('The sockets extension is not loaded.');
		}
		// create unix udp socket
		$this->soket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
		if (!$this->soket)
			throw new Exception('Unable to create AF_UNIX socket');

		// same socket will be later used in recv_from
		// no binding is required if you wish only send and never receive
		$this->client_side_sock = "/tmp/client.sock";
		if (!socket_bind($this->soket, $this->client_side_sock))
			throw new Exception("Unable to bind to $this->client_side_sock");

		// use socket to send data
		if (!socket_set_nonblock($this->soket))
			throw new Exception('Unable to set nonblocking mode for socket');


	}

	function call(string $message): string
	{
		$len = strlen($message);

		// at this point 'server' process must be running and bound to receive from serv.sock
		$bytes_sent = socket_sendto($this->soket, $message, $len, 0, $this->server_side_sock);

		if ($bytes_sent == -1)
			throw new Exception('An error occurred while sending to the socket');
		else if ($bytes_sent != $len)
			throw new Exception($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');

		// use socket to receive data
		if (!socket_set_block($this->soket))
			throw new Exception('Unable to set blocking mode for socket');

		$response = '';
		$from = '';
		// will block to wait server response
		$bytes_received = socket_recvfrom($this->soket, $response, 65536, 0, $from);
		if ($bytes_received == -1) {
			throw new Exception('An error occurred while receiving from the socket');
		}
		//echo "Received $response from $from\n";
		return $response;
	}

	function dispose()
	{
		// close socket and delete own .sock file
		socket_close($this->soket);
		unlink($this->client_side_sock);
		echo "Client exits\n";
	}

}
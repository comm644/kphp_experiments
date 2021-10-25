<?php


namespace Sigmalab\AdoDatabase\Transport\Server;


class ServerUdp
{
	private string $serverAddress = "127.0.0.1";
	private int $serverPort = 43026;

	/**
	 * info: copied form php.net
	 *
	 * @param string $serverAddr
	 * @param int $serverPort
	 * @param callable $app
	 */
	function main(string $serverAddr, int $serverPort, callable $app)
	{
		$this->serverAddress = $serverAddr;
		$this->serverPort = $serverPort;
		if (!extension_loaded('sockets')) {
			die('The sockets extension is not loaded.');
		}

		// create unix udp socket
		$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
		if (!$socket)
			die('Unable to create AF_UNIX socket');

		// same socket will be used in recv_from and send_to
		if (!socket_bind($socket, $this->serverAddress, $this->serverPort))
			die("Unable to bind to $this->serverAddress");

		// receive query
		if (!socket_set_block($socket)) {
			die('Unable to set blocking mode for socket');
		}

		while (1) // server never exits
		{
			$buffer = '';
			$from = '';
			$fromPort = 0;
			echo "Ready to receive...\n";
			// will block to wait client query
			$bytes_received = socket_recvfrom($socket, $buffer, 65536, 0, $from, $fromPort);
			if ($bytes_received == -1) {
				echo('An error occured while receiving from the socket');
				continue;
			}

			//echo "Received $buffer from $from\n";

			$rpcResponse = $app($buffer);

			//$buffer .= "->Response"; // process client query here

			// send response
			if (!socket_set_nonblock($socket)) {
				echo('Unable to set nonblocking mode for socket');
				continue;
			}
			echo "\nfrom: $from:$fromPort\n";

			// client side socket filename is known from client request: $from
			$len = strlen($rpcResponse);
			$bytes_sent = socket_sendto($socket, $rpcResponse, $len, 0, $from, $fromPort);
			if ($bytes_sent == -1) {
				echo 'An error occured while sending to the socket';
				continue;
			} else if ($bytes_sent != $len) {
				echo($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
			}

			echo "Request processed\n";
		}
	}
}
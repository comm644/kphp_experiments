<?php


namespace Sigmalab\AdoDatabase\Transport\Server;


class ServerUnixDgram
{
	private string $server_side_sock = '';

	function main(string $serverSockFile, callable $app)
	{
		$this->server_side_sock = $serverSockFile;
		unlink($this->server_side_sock);

		if (!extension_loaded('sockets')) {
			die('The sockets extension is not loaded.');
		}

		// create unix udp socket
		$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
		if (!$socket)
			die('Unable to create AF_UNIX socket');

		// same socket will be used in recv_from and send_to
		if (!socket_bind($socket, $this->server_side_sock))
			die("Unable to bind to $this->server_side_sock");

		while (1) // server never exits
		{
			// receive query
			if (!socket_set_block($socket))
				die('Unable to set blocking mode for socket');
			$buffer = '';
			$from = '';
			echo  "Ready to receive...\n";
			// will block to wait client query
			$bytes_received = socket_recvfrom($socket, $buffer, 65536, 0, $from);
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
// client side socket filename is known from client request: $from
			$len = strlen($rpcResponse);
			$bytes_sent = socket_sendto($socket, $rpcResponse, $len, 0, $from);
			if ($bytes_sent == -1) {
				echo 'An error occured while sending to the socket';
				continue;
			}
			else if ($bytes_sent != $len)
				echo($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');

			echo "Request processed\n";
		}
	}
}
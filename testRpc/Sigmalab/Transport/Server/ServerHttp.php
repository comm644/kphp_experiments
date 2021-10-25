<?php


namespace Sigmalab\AdoDatabase\Transport\Server;


class ServerHttp
{
	function main(string $serverAddr, callable $app)
	{
		$socket = stream_socket_server("tcp://$serverAddr", $errno, $errstr);

		if (!$socket) {
			echo $errstr, ' (', $errno,')', PHP_EOL;
		} else {
			$defaults = array(
				'Content-Type' => 'text/html',
				'Server' => 'PHP '.phpversion()
			);
			echo "Server is running on $serverAddr, relax.", PHP_EOL;
			while ($conn = stream_socket_accept($socket, -1)) {
				//stream_set_blocking($conn, false);
				$request = '';
				while (true) {
					$buf = fread($conn, 4096);
					$request .= $buf;
					if  (!strlen($buf) != 4096) {
						break;
					}
				}

				$code = 200;
				$parts = substr($request, strpos($request, "\r\n\r\n" ));

				//ob_start();
				//print_r($parts);
				$body = trim($parts, "\r\n"); //ob_get_clean();

				$headers = [];
				if ( $body ) {
					$body = $app($body);
				}
				else {
					$body = "Message not found";
				}

				$headers += $defaults;
				if (!isset($headers['Content-Length'])) {
					$headers['Content-Length'] = strlen($body);
				}
				$header = '';
				foreach ($headers as $k => $v) {
					$header .= $k . ': ' . $v . "\r\n";
				}
				fwrite($conn, implode("\r\n", array(
					'HTTP/1.1 '.$code,
					$header,
					$body
				)));
				fflush($conn);
				fclose($conn);
			}
			fclose($socket);
		}
	}
}
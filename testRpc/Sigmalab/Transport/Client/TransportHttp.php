<?php

namespace Sigmalab\AdoDatabase\TransportClient;

class TransportHttp implements ITransport
{
	/**
	 * @var string
	 */
	private string $serverUrl;
	/**
	 * @var array
	 */
	private array $headers;
	/**
	 * @var false|resource
	 */
	private $ch;
	private string $lastResult = "";

	/**
	 * HttpTransport constructor.
	 * @param string $serverUrl
	 * @param array $gateHeaders
	 */
	public function __construct(string $serverUrl, array $gateHeaders = [])
	{
		$this->serverUrl = $serverUrl;
		$this->headers = $gateHeaders;
	}

	function start()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($this->ch, CURLOPT_FORBID_REUSE,1);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_URL, $this->serverUrl);
	}

	function call(string $message): string
	{
		
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $message);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);

		$parts = parse_url($this->serverUrl);
		if  (isset($parts['port']) ){
			curl_setopt($this->ch, CURLOPT_PORT, intval($parts['port']));
		}
		$output = curl_exec($this->ch);

		$this->lastResult = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

		return (string)$output;
	}

	function dispose()
	{
		curl_close($this->ch);
	}

}
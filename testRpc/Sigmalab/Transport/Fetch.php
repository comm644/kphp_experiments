<?php
namespace Sigmalab\Transport;

/**
 * Class Fetch provides KPHP compatible fetch service for Gate*
 *
 * @package Integration
 */
class Fetch
{
	/**
	 * @var mixed
	 */
	public static $lastResult = 0;
	/**
	 * @var false|string
	 */
	public static string $lastHeaders = "";

	/** Simple fetch post instead of file_get_contents()
	 * @param string $url
	 * @param string[] $params
	 * @param string[] $headers
	 * @return string|null
	 */
	public static function fetchPost(string $url, array $params, array $headers=[]) : ?string
	{
		$payload = http_build_query($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$output = curl_exec($ch);

		self::$lastResult = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $output;
	}
	/** Simple fetch post instead of file_get_contents()
	 * @param string $url
	 * @param string $payload
	 * @param string[] $headers
	 * @return string|null
	 */
	public static function fetchPostContent(string $url, string $payload, array $headers=[]) : ?string
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($ch, CURLOPT_FORBID_REUSE,1);

		$parts = parse_url($url);
		if  (isset($parts['port']) ){
			curl_setopt($ch, CURLOPT_PORT, intval($parts['port']));
		}
		$output = curl_exec($ch);

		self::$lastResult = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return (string)$output;
	}


	/** Simple fetch post instead of file_get_contents()
	 * @param string $url
	 * @param string[] $params
	 * @param string[] $headers
	 * @return string|null
	 */
	public static function fetchGet(string $url, array $params, array $headers=[]) : ?string
	{
		$payload = http_build_query($params);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 0);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 1);


		$response = curl_exec($ch);

		self::$lastResult = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		curl_close($ch);

		self::$lastHeaders = $header;

		return $body;
	}
}

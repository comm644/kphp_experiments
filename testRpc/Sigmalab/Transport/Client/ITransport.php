<?php

namespace Sigmalab\AdoDatabase\TransportClient;

interface ITransport
{
	function start();

	function call(string $message): string;

	function dispose();
}
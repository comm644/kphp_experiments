<?php

namespace Sigmalab\Database\Core;

define('DBParamType_integer', 0);
define('DBParamType_real', 1);
define('DBParamType_bool', 2);
define('DBParamType_string', 3);
define('DBParamType_lob', 4);
define('DBParamType_null', 5);


class DBParamType
{
	const Integer = DBParamType_integer;
	const String = DBParamType_string;
	const Lob = DBParamType_lob;
	const Real = DBParamType_real;
	const Bool = DBParamType_bool;
	const Null = DBParamType_null;
}
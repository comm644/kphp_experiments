<?php
/******************************************************************************
 * Copyright (c) 2003-2009 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : Database Value type
 * File       : DBValueType.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description: module describes common database types.
 *
 * 2021:  const enumeration class DBValueType
 ******************************************************************************/

namespace Sigmalab\Database\Core;
define("DBValueType_integer", 'integer');
define("DBValueType_string", 'string');
define("DBValueType_blob", 'blob');
define("DBValueType_datetime", 'datetime');
define("DBValueType_real", 'float');
define("DBValueType_float", 'float');


class DBValueType
{
	const TypeInteger = DBValueType_integer;
	const TypeString = DBValueType_string;
	const TypeBlob = DBValueType_blob;
	const TypeDatetime = DBValueType_datetime;
	const TypeReal = DBValueType_real;
	const TypeFloat = DBValueType_float;
}
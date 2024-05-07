<?php

/* SECURITY */

define ('SECRET_KEY', 'thisissecretkey');

/* DATA TYPES */
define ('BOOLEAN', '1');
define ('INTEGER', '2');
define ('STRING' , '3');

/* ERROR DESCRIPTIONS */

define('MESSAGE_SORRY', 'Something went wrong! Please contact support.');
define('DESC_INCORRECT_PASSWORD', 'Incorrect password');

/* ERROR CODES */

define ('REQUEST_METHOD_NOT_VALID',				100);
define ('REQUEST_CONTENT_TYPE_NOT_VALID',		101);
define ('REQUEST_NOT_VALID',					102);
define ('VALID_PARAMETER_REQUIRED',				103);
define ('VALID_PARAMETER_DATATYPE_REQUIRED',	104);
define ('API_NAME_REQUIRED',					105);
define ('API_PARAM_REQUIRED',					106);
define ('API_DOES_NOT_EXIST',					107);
define ('INVALID_USER_PASSWORD'	,				108);
define ('JWT_PROCESSING_ERROR',					109);
define ('AUTHORIZATION_HEADER_NOT_FOUND',		110);
define ('SUCCESS_RESPONSE',						200);

define('CODE_UNAUTHORIZED',                     401);
define ('CODE_NOT_FOUND',                       404);
define ('CODE_UNPROCESSABLE_ENTITY',            422);
define ('CODE_INTERNAL_ERROR',                  500);


?>

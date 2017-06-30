<?php

$http_codes = [
	'200' => [
		'code' => 200,
		'status' => 'OK',
		'message' => 'Eyerything is working.'
	],
	'201' => [
		'code' => 201,
		'status' => 'OK',
		'message' => 'New resource has been created.'
	],
    '202' => [
		'code' => 202,
		'status' => 'Accepted',
		'message' => 'Request has been accepted.'
	],
	'204' => [
		'code' => 204,
		'status' => 'OK',
		'message' => 'The resource was successfully deleted.'
	],
	'304' => [
		'code' => 304,
		'status' => 'Not Modified',
		'message' => 'The client can use cached data.'
	],
	'400' => [
		'code' => 400,
		'status' => 'Bad Request',
		'message' => 'The request was invalid or cannot be served.'
	],
	'401' => [
		'code' => 401,
		'status' => 'Unauthorized',
		'message' => 'The request requires an user authentication.'
	],
	'403' => [
		'code' => 403,
		'status' => 'Forbidden',
		'message' => 'The server understood the request, but is refusing it or the access is not allowed.'
	],
	'404' => [
		'code' => 404,
		'status' => 'Not found',
		'message' => 'Resource not found.'
	],
    '405' => [
		'code' => 405,
		'status' => 'Method Not Allowed',
		'message' => 'Method not allowed.'
	],
    '410' => [
		'code' => 410,
		'status' => 'Gone',
		'message' => 'Resource at this end point is no longer available.'
	],
    '415' => [
		'code' => 415,
		'status' => 'Unsupported Media Type',
		'message' => 'Unsupported media type.'
	],
	'422' => [
		'code' => 422,
		'status' => 'Unprocessable Entity',
		'message' => 'Unprocessable entity.'
	],
    '429' => [
		'code' => 429,
		'status' => 'Too Many Requests',
		'message' => 'Too many requests.'
	],
	'500' => [
		'code' => 500,
		'status' => 'Internal Server Error',
		'message' => 'Internal server error.'
	]
];

$config['http_codes'] = $http_codes;
return $config;
<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Origin
	|--------------------------------------------------------------------------
	|
	| Specifies the fully qualified domain name of the PubNub origin. By
	| default this value is set to pubsub.pubnub.com but it should be set to
	| the appropriate origin specified in the PubNub Admin Portal.
	|
	*/

	'origin'        => 'pubsub.pubnub.com',

	/*
	|--------------------------------------------------------------------------
	| Publish Key
	|--------------------------------------------------------------------------
	|
	| Specifies the publish_key to be used for publishing messages to a channel.
	|
	*/

	'publish_key'   => '',

	/*
	|--------------------------------------------------------------------------
	| Subscribe Key
	|--------------------------------------------------------------------------
	|
	| Specifies the subscribe_key to be used for subscribing to a channel.
	|
	*/

	'subscribe_key' => '',

	/*
	|--------------------------------------------------------------------------
	| SSL
	|--------------------------------------------------------------------------
	|
	| Setting a value of true enables transport layer encryption with SSL/TLS.
	|
	*/

	'ssl' => FALSE,

	/*
	|--------------------------------------------------------------------------
	| Secret Key
	|--------------------------------------------------------------------------
	|
	| Specifies the secret key.
	|
	*/

	'secret_key'    => FALSE,

	/*
	|--------------------------------------------------------------------------
	| Cipher Key
	|--------------------------------------------------------------------------
	|
	| Specifies a cryptographic key to use for message level encryption with
	| AES. The cipher_key specifies the particular transformation of plain text
	| into cipher text, or vice versa during decryption.
	|
	*/

	'cipher_key'    => FALSE,

];
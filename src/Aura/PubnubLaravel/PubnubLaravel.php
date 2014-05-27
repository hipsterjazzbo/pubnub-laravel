<?php namespace Aura\PubnubLaravel;

use \Closure;
use \Pubnub\Pubnub;
use \Illuminate\Support\Facades\Config;
use \Aura\PubnubLaravel\Exceptions\PubnubChannelException;
use \Aura\PubnubLaravel\Exceptions\PubnubPublishFailedException;
use \Aura\PubnubLaravel\Exceptions\PubnubSubscribeFailedException;

class PubnubLaravel {

	protected $pubnub;
	protected $channel;

	public function __construct()
	{
		$publish_key   = Config::get('pubnub-laravel::publish_key');
		$subscribe_key = Config::get('pubnub-laravel::subscribe_key');
		$secret_key    = Config::get('pubnub-laravel::secret_key');
		$cipher_key    = Config::get('pubnub-laravel::cipher_key');
		$ssl           = Config::get('pubnub-laravel::ssl');
		$origin        = Config::get('pubnub-laravel::origin');
		$pem_path      = Config::get('pubnub-laravel::pem_path');

		$this->pubnub = new Pubnub($publish_key, $subscribe_key, $secret_key, $cipher_key, $ssl, $origin, $pem_path);
	}

	/**
	 * @param $channel
	 */
	public function setChannel($channel)
	{
		$this->channel = $channel;
	}

	/**
	 * @param string $overrideChannel
	 *
	 * @return string
	 * @throws \Aura\PubnubLaravel\Exceptions\PubnubChannelException
	 */
	public function getChannel($overrideChannel = NULL)
	{
		if (is_null($overrideChannel) && is_null($this->channel))
		{
			throw new PubnubChannelException('You must either set a channel using Pubnub::setChannel() or using the $channel parameter');
		}

		return $overrideChannel ?: $this->channel;
	}

	/**
	 * @param string $message
	 * @param string $channel
	 *
	 * @throws \Aura\PubnubLaravel\Exceptions\PubnubPublishFailedException
	 * @return bool
	 */
	public function publish($message, $channel = NULL)
	{
		$args = [
			'channel' => $this->getChannel($channel),
			'message' => $message
		];

		$response = $this->pubnub->publish($args);

		// The Pubnub library will return either false or a weird array with key [0] === 0, indicating failure.
		// Detect these cases and throw a nice exception instead.
		if ($response === FALSE || (is_array($response) && $response[0] === 0))
		{
			throw new PubnubPublishFailedException;
		}

		// Otherwise, pubnub returns an array of information that doesn't matter.
		// Ignore it and just return true.
		return TRUE;
	}

	/**
	 * @param callable $callback
	 * @param string   $channel
	 * @param bool     $presence
	 *
	 * @throws \Aura\PubnubLaravel\Exceptions\PubnubSubscribeFailedException
	 * @return bool
	 */
	public function subscribe(Closure $callback, $channel = NULL, $presence = FALSE)
	{
		$callbackWrapper = function ($responseArray) use ($callback)
		{
			// If we get back a weird array with [0] === 0, something is wrong.
			// Detect that and throw a nice exception instead.
			if (isset($responseArray[0]) && $responseArray[0] === 0)
			{
				$errorMessage = $responseArray[1];

				throw new PubnubSubscribeFailedException($errorMessage);
			}

			return $callback((object) $responseArray['message']);
		};

		$args = [
			'channel'  => $this->getChannel($channel),
			'callback' => $callbackWrapper
		];

		$response = $this->pubnub->subscribe($args, $presence);

		// Pubnub library detected something wrong
		if ($response === FALSE)
		{
			throw new PubnubSubscribeFailedException;
		}

		return TRUE;
	}

	/**
	 * @param callable $callback
	 * @param array    $channel
	 *
	 * @throws \Aura\PubnubLaravel\Exceptions\PubnubSubscribeFailedException
	 * @return bool
	 */
	public function presence(Closure $callback, $channel = NULL)
	{
		return $this->subscribe($callback, $channel, TRUE);
	}

	/**
	 * @param string $channel
	 *
	 * @return false|array False on failure, an array of present uuids on success
	 */
	public function hereNow($channel = NULL)
	{
		$args = [
			'channel' => $this->getChannel($channel)
		];

		$response = $this->pubnub->here_now($args);

		if ($response === FALSE)
		{
			return FALSE;
		}

		return $response['uuids'];
	}
}
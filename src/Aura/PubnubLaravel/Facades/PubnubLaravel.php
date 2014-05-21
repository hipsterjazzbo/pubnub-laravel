<?php namespace Aura\PubnubLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class PubnubLaravel extends Facade {

	protected static function getFacadeAccessor() { return 'pubnub'; }
} 
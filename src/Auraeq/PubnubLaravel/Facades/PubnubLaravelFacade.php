<?php namespace Auraeq\PubnubLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class PubnubLaravelFacade extends Facade {

	protected static function getFacadeAccessor() { return 'pubnub'; }
} 
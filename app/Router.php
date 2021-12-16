<?php
/**
 * Custom router which handles default middlewares, default exceptions and things
 * that should be happen before and after the router is initialised.
 */
namespace App;

use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{
    public static function start(): void
	{
		// Load our helpers
		require_once __DIR__.'/helpers.php';

		// Load our custom routes
		require_once __DIR__.'/../routes/web.php';

		// Do initial stuff
		parent::start();
	}

}
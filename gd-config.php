<?php

define( 'GD_VIP', '184.168.47.225' );
define( 'GD_RESELLER', 1 );
define( 'GD_ASAP_KEY', 'd34e889422eb150dec4202aea916d827' );

// Newrelic tracking
if ( function_exists( 'newrelic_set_appname' ) ) {
	newrelic_set_appname( 'ac16310e-092c-4dfe-b006-84b53e8dfd8a;' . ini_get( 'newrelic.appname' ) );
}

/**
 * Is this is a mobile client?  Can be used by batcache.
 * @return array
 */
function is_mobile_user_agent() {
	return array(
	       "mobile_browser"             => !in_array( $_SERVER['HTTP_X_UA_DEVICE'], array( 'bot', 'pc' ) ),
	       "mobile_browser_tablet"      => false !== strpos( $_SERVER['HTTP_X_UA_DEVICE'], 'tablet-' ),
	       "mobile_browser_smartphones" => in_array( $_SERVER['HTTP_X_UA_DEVICE'], array( 'mobile-iphone', 'mobile-smartphone', 'mobile-firefoxos', 'mobile-generic' ) ),
	       "mobile_browser_android"     => false !== strpos( $_SERVER['HTTP_X_UA_DEVICE'], 'android' )
	);
}
define( 'REDIS_SOCKET', '/var/run/RedisProxy/mwprp.sock' );

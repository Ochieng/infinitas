<?php
	/**
	 * This is core configuration file.
	 *
	 * Used to configure some base settings and load configs from all the plugins in the app.
	 */
	if(substr(env('SERVER_ADDR'), 0, 3) == 127){
		Configure::write('debug', 2);
	}
	else{
		Configure::write('debug', 0);
	}
	
	Configure::write('log', true);

	/**
	 * @brief Error logging level
	 *
	 * Same as the debug level, but will send errors to a file. Good to see
	 * what is going on when the site's debug is off.
	 */
	define('LOG_ERROR', 2);

	if(phpversion() >= 5.3){
		date_default_timezone_set(date_default_timezone_get());
	}

	/**
	 * if debug is off check for view file cache
	 */
	if(Configure::read('debug') == 0){
		Configure::write('Cache.check', true);
	}

	App::build(array('Plugin' => array(APP . 'Core' . DS)));


	/**
	 * Cache configuration.
	 *
	 * Try apc or memcache, default to the namespaceFile cache.
	 */
	$cacheEngine = 'File';
	switch(true){
		case function_exists('apc_cache_info') && ini_get('apc.enabled'):
			$cacheEngine = 'Apc';
			break;
		
		case function_exists('xcache_info'):
			$cacheEngine = 'Xcache';
			break;

		case class_exists('Memcache'):
			$cacheEngine = 'Memcache';
			break;

		default:
			$cacheEngine = 'Libs.NamespaceFile';
			break;
	}
	Configure::write('Cache.engine', $cacheEngine);
	
	$cachePrefix = substr(sha1(env('DOCUMENT_ROOT') . env('HTTP_HOST')), 0, 10);
	Cache::config('_cake_core_', array('engine' => $cacheEngine, 'prefix' => $cachePrefix));
	Cache::config('_cake_model_', array('engine' => $cacheEngine, 'prefix' => $cachePrefix));
	Cache::config('default', array('engine' => $cacheEngine, 'prefix' => $cachePrefix));
	unset($cacheEngine);

	/**
	 * @brief get the configuration values from cache
	 *
	 * If they are available, set them to the Configure object else run the
	 * Event to get the values from all the plugins and cache them
	 */
	$cachedConfigs = Cache::read('global_configs');
	if(!empty($cachedConfigs)){
		foreach($cachedConfigs as $k => $v){
			Configure::write($k, $v);
		}
	}

	//no home
	Configure::write('Rating.require_auth', true);
	Configure::write('Rating.time_limit', '4 weeks');
	Configure::write('Reviews.auto_moderate', true);

	if(!empty($cachedConfigs)) {
		unset($cachedConfigs);
		return true;
	}

	/**
	 * @todo cake2.0
	 * Cache::write('global_configs', Configure::getInstance());
	 */
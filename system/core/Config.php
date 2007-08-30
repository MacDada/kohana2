<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Kohana
 *
 * A secure and lightweight open source web application framework.
 *
 * @package          Kohana
 * @author           Kohana Development Team
 * @copyright        Copyright (c) 2007, Kohana Framework Team
 * @link             http://kohanaphp.com
 * @license          http://kohanaphp.com/license.html
 * @since            Version 2.0
 * @filesource
 * $Id$
 */

// ----------------------------------------------------------------------------

/**
 * Configuration class
 *
 * @category    Core
 * @author      Kohana Development Team
 * @link        http://kohanaphp.com/user_guide/core_classes.html
 */
final class Config {

	public static $conf; // Configuration array

	private static $include_paths;

	/**
	 * Return a config item
	 *
	 * @access  public
	 * @param   string
	 * @return  mixed
	 */
	public static function item($key, $slash = FALSE)
	{
		// Configuration autoloading
		if (self::$conf === NULL)
		{
			require APPPATH.'config'.DIRECTORY_SEPARATOR.'config'.EXT;

			// Invalid config file
			(isset($config) AND is_array($config)) or die
			(
				'Core configuration file is not valid.'
			);

			// Start setting include paths, APPPATH first
			self::$include_paths = array(APPPATH);

			// Normalize all paths to be absolute and have a trailing slash
			foreach($config['include_paths'] as $path)
			{
				if (($path = realpath($path)) == '') continue;

				self::$include_paths[] = realpath($path).DIRECTORY_SEPARATOR;
			}

			// Finish setting include paths by adding SYSPATH
			self::$include_paths[] = SYSPATH;

			// Load config into self
			self::$conf['core'] = $config;
		}

		// Find the requested key
		$key  = explode('.', $key);
		// Find type and reset the key
		$type = $key[0];
		$key  = isset($key[1]) ? $key[1] : FALSE;

		// Load config arrays
		if ( ! isset(self::$conf[$type]))
		{
			self::$conf[$type] = self::load($type);
		}

		$value = FALSE;

		// Fetch config groups
		if ($key === FALSE)
		{
			$value = self::$conf[$type];
		}
		// Fetch config items
		elseif (isset(self::$conf[$type][$key]))
		{
			$value = self::$conf[$type][$key];

			// Add ending slashes
			if ($slash == TRUE AND $value != '')
			{
				$value = rtrim($value, '/').'/';
			}
		}

		return $value;
	}

	/**
	 * Return the include paths
	 *
	 * @access  public
	 * @return  array
	 */
	public static function include_paths()
	{
		return self::$include_paths;
	}

	/**
	 * Load a config file
	 *
	 * @access  public
	 * @param   string
	 * @return  array
	 */
	public static function load($name, $required = TRUE)
	{
		$required = (bool) $required;
		$configuration = array();

		foreach(Kohana::find_file('config', $name, $required) as $filename)
		{
			include $filename;

			// Merge in configuration
			if (isset($config) AND is_array($config))
			{
				$configuration = array_merge($configuration, $config);
			}
		}

		return $configuration;
	}

} // End Config class
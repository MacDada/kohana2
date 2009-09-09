<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Kohana PHP Error Exceptions
 *
 * $Id$
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */

class Kohana_PHP_Exception_Core extends Kohana_Exception {

	public static $disabled = FALSE;

	/**
	 * Enable Kohana PHP error handling.
	 *
	 * @return  void
	 */
	public static function enable()
	{
		// Register with non shutdown errors
		set_error_handler(array('Kohana_PHP_Exception', 'error_handler'));

		// Register a shutdown function to handle errors which halt execution
		register_shutdown_function(array('Kohana_PHP_Exception', 'shutdown_handler'));
	}

	/**
	 * Disable Kohana PHP error handling.
	 *
	 * @return  void
	 */
	public static function disable()
	{
		self::$disabled = TRUE;
		restore_error_handler();
	}

	/**
	 * Create a new PHP error exception.
	 *
	 * @return  void
	 */
	public function __construct($code, $error, $file, $line, $context = NULL)
	{
		parent::__construct($error);

		// Set the error code, file, line, and context manually
		$this->code = $code;
		$this->file = $file;
		$this->line = $line;
	}

	/**
	 * PHP error handler.
	 *
	 * @throws  Kohana_PHP_Exception
	 * @return  void
	 */
	public static function error_handler($code, $error, $file, $line, $context = NULL)
	{
		// Respect error_reporting settings
		if (error_reporting() & $code)
		{
			// An error has been triggered
			Kohana::$has_error = TRUE;

			// Throw an exception
			throw new Kohana_PHP_Exception($code, $error, $file, $line, $context);
		}
	}

	/**
	 * Catches errors that are not caught by the error handler, such as E_PARSE.
	 *
	 * @uses    Kohana_Exception::handle()
	 * @return  void
	 */
	public static function shutdown_handler()
	{
		if ( ! self::$disabled AND $error = error_get_last())
		{
			// Fake an exception for nice debugging
			Kohana_Exception::handle(new Kohana_PHP_Exception($error['type'], $error['message'], $error['file'], $error['line']));
		}
	}
} // End Kohana PHP Exception
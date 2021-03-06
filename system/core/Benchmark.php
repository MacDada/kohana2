<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Simple benchmarking.
 * 
 * ##### Basic Usage
 * 	//Start tracking time
 * 	Benchmark::start('My Code Section');
 * 	
 * 	//call some function that takes time
 * 	do_something_cpu_intensive();
 * 	
 * 	//Stop the benchmark, results can be viewed with the profiler see profiler class for details
 * 	Benchmark::stop('My Code Section');
 * 
 * 	//Get results
 * 	$time = Benchmark::get('My Code Section');
 * 
 * @package    Kohana
 * @author     Kohana Team
 * @copyright  (c) 2007-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */
final class Benchmark {

	// Benchmark timestamps
	private static $marks;

	/**
	 * Set a benchmark start point.
	 * 
	 * ##### Example
	 * 	Benchmark::start('Name of Section');
	 * 
	 * @param   string $name benchmark name
	 * @return  void
	 */
	public static function start($name)
	{
		if (isset(self::$marks[$name]) AND self::$marks[$name][0]['stop'] === FALSE)
			throw new Kohana_Exception('A benchmark named :name is already running.', array(':name' => $name));

		if ( ! isset(self::$marks[$name]))
		{
			self::$marks[$name] = array();
		}

		$mark = array
		(
			'start'        => microtime(TRUE),
			'stop'         => FALSE,
			'memory_start' => self::memory_usage(),
			'memory_stop'  => FALSE
		);

		array_unshift(self::$marks[$name], $mark);
	}

	/**
	 * Set a benchmark stop point.
	 * 
	 * ##### Example
	 * 	Benchmark::stop('Name of Section');
	 * 
	 * @param   string $name benchmark name
	 * @return  void
	 */
	public static function stop($name)
	{
		if (isset(self::$marks[$name]) AND self::$marks[$name][0]['stop'] === FALSE)
		{
			self::$marks[$name][0]['stop'] = microtime(TRUE);
			self::$marks[$name][0]['memory_stop'] = self::memory_usage();
		}
	}

	/**
	 * Get the elapsed time between a start and stop.
	 * 
	 * ##### Examples
	 * 	//get time in default format
	 * 	$time = Benchmark::get('Name of Section');
	 * 
	 * 	//get time to 6 decimal places
	 * 	$time = Benchmark::get('Name of Section', 6);
	 * 
	 * @param   string $name  benchmark name, TRUE for all
	 * @param   integer $decimals [optional] number of decimal places to count to
	 * @return  array
	 */
	public static function get($name, $decimals = 4)
	{
		if ($name === TRUE)
		{
			$times = array();
			$names = array_keys(self::$marks);

			foreach ($names as $name)
			{
				// Get each mark recursively
				$times[$name] = self::get($name, $decimals);
			}

			// Return the array
			return $times;
		}

		if ( ! isset(self::$marks[$name]))
			return FALSE;

		if (self::$marks[$name][0]['stop'] === FALSE)
		{
			// Stop the benchmark to prevent mis-matched results
			self::stop($name);
		}

		// Return a string version of the time between the start and stop points
		// Properly reading a float requires using number_format or sprintf
		$time = $memory = 0;
		for ($i = 0; $i < count(self::$marks[$name]); $i++)
		{
			$time += self::$marks[$name][$i]['stop'] - self::$marks[$name][$i]['start'];
			$memory += self::$marks[$name][$i]['memory_stop'] - self::$marks[$name][$i]['memory_start'];
		}

		return array
		(
			'time'   => number_format($time, $decimals),
			'memory' => $memory,
			'count'  => count(self::$marks[$name])
		);
	}

	/**
	 * Returns the current memory usage. This is only possible if the
	 * memory_get_usage function is supported in PHP.
	 *
	 * @return  integer
	 */
	private static function memory_usage()
	{
		static $func;

		if ($func === NULL)
		{
			// Test if memory usage can be seen
			$func = function_exists('memory_get_usage');
		}

		return $func ? memory_get_usage() : 0;
	}

} // End Benchmark

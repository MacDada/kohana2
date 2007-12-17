<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class: array_helper
 *  Array helper class.
 *
 * Kohana Source Code:
 *  author    - Kohana Team
 *  copyright - (c) 2007 Kohana Team
 *  license   - <http://kohanaphp.com/license.html>
 */
class arr_Core {
	
	/**
	 * Method: rotate
	 *  Rotates a 2D array clockwise.
	 *  Example, turns a 2x3 array into a 3x2 array
	 *
	 * Parameters:
	 *  source_array - the array to rotate
	 *  keep_keys - keep the keys in the final rotated array. the sub arrays of the source array need to have the same key values.
	 *              if your subkeys might not match, you need to pass FALSE here!
	 *
	 * Returns:
	 *  The transformed array
	 */
	public function rotate($source_array, $keep_keys = TRUE)
	{
		$new_array = array();
		foreach ($source_array as $key => $value)
		{
			$value = ($keep_keys) ? $value : array_values($value);
			foreach ($value as $k => $v)
			{
				$new_array[$k][$key] = $v;
			}
		}
		
		return $new_array;
	}
	
	/**
	 * Method: remove
	 *  Removes a key from an array and returns the value
	 *
	 * Parameters:
	 *  key - to key to return
	 *  array - the array to work on
	 *
	 * Returns:
	 *  The value of the requested array key
	 */
	public function remove($key, & $array)
	{
		if ( ! isset($array[$key]))
			return NULL;

		$val = $array[$key];
		unset($array[$key]);

		return $val;
	}

	/**
	 * Because PHP does not have this function.
	 *
	 * @param   array   array to unshift
	 * @param   string  key to unshift
	 * @param   mixed   value to unshift
	 * @return  array
	 */
	public function unshift_assoc( array & $array, $key, $val)
	{
		$array = array_reverse($array, TRUE);
		$array[$key] = $val;
		$array = array_reverse($array, TRUE);

		return $array;
	}

	/**
	 * Binary search algorithm.
	 *
	 * @param   mixed  the value to search for
	 * @param   array  an array of values to search in
	 * @return  integer
	 */
	public function binary_search($needle, $haystack, $return = FALSE)
	{
		$high = count($haystack);
		$low = 0;

		while ($high - $low > 1)
		{
			$probe = ($high + $low) / 2;
			if ($haystack[$probe] < $needle)
			{
				$low = $probe;
			}
			else
			{
				$high = $probe;
			}
		}

		if ($high == count($haystack) OR $haystack[$high] != $needle)
			return ($return) ? floor($low) : FALSE;
		else
			return $high;
	}
} // End arr
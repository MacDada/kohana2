<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BlueFlame
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		BlueFlame
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://www.codeigniter.com/user_guide/license.html
 * @link		http://blueflame.ciforge.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * BlueFlame Inflector Helpers
 *
 * @package		BlueFlame
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/helpers/directory_helper.html
 */


// --------------------------------------------------------------------

/**
 * Singular
 *
 * Takes a singular word and makes it plural
 *
 * @access	public
 * @param	string
 * @return	str
 */
function singular($str)
{
	$str = trim($str);
	$end = substr($str, -3);

	if ($end == 'ies')
	{
		$str = substr($str, 0, strlen($str)-3).'y';
	}
	elseif ($end == 'ses' || $end == 'zes' || $end == 'xes')
	{
		$str = substr($str, 0, strlen($str)-2);
	}
	else
	{
		$end = substr($str, -1);

		if ($end == 's')
		{
			$str = substr($str, 0, strlen($str)-1);
		}
	}

	return $str;
}

// --------------------------------------------------------------------

/**
 * Plural
 *
 * Takes a plural word and makes it singular
 *
 * @access	public
 * @param	string
 * @return	str
 */
function plural($str)
{
	$str = trim($str);
	$end = substr($str, -1);
	$low = (strcmp($end, strtolower($end)) === 0) ? TRUE : FALSE;

	if (preg_match('/[sxz]$/i', $str) OR preg_match('/[^aeioudgkprt]h$/i', $str))
	{
		$end = 'es';
		$str .= ($low == FALSE) ? strtoupper($end) : $end;
	}
	elseif (preg_match('/[^aeiou]y$/i', $str))
	{
		$end = 'ies';
		$end = ($low == FALSE) ? strtoupper($end) : $end;
		$str = substr_replace($str, $end, -1);
	}
	else
	{
		$end = 's';
		$str .= ($low == FALSE) ? strtoupper($end) : $end;
	}

	return $str;
}

// --------------------------------------------------------------------

/**
 * Camelize
 *
 * Takes multiple words separated by spaces or underscores and camelizes them
 *
 * @access	public
 * @param	string
 * @return	str
 */
function camelize($str)
{
	$str = 'x'.strtolower(trim($str));
	$str = ucwords(preg_replace('/[\s_]+/', ' ', $str));
	return substr(str_replace(' ', '', $str), 1);
}

// --------------------------------------------------------------------

/**
 * Underscore
 *
 * Takes multiple words separated by spaces and underscores them
 *
 * @access	public
 * @param	string
 * @return	str
 */
function underscore($str)
{
	return preg_replace('/\s+/', '_', strtolower(trim($str)));
}

// --------------------------------------------------------------------

/**
 * Humanize
 *
 * Takes multiple words separated by underscores and changes them to spaces
 *
 * @access	public
 * @param	string
 * @return	str
 */
function humanize($str)
{
	return ucwords(preg_replace('/_+/', ' ', strtolower(trim($str))));
}

?>
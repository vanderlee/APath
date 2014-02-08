<?php

	/**
	 * APath
	 *
	 * @version 0.1
	 * @author Martijn W. van der Lee <martijn-at-vanderlee-dot-com>
	 * @copyright Copyright (c) 2014, Martijn W. van der Lee
	 * @license http://www.opensource.org/licenses/mit-license.php
	 */

	function apath__expression($expression, $index, &$array) {
		// Strip out any existing replacing operator
		if (preg_match('~[&|/%]~', $expression) === 1) {
			return false;
		}

		$expression = strtr($expression, array(
			'div'			=> ' / ',
			'mod'			=> ' % ',
			'and'			=> ' && ',
			'or'			=> ' || ',
			'first()'		=> 1,
			'odd()'			=> ($index % 2)? '(1=1)' : '(1=0)',
			'even()'		=> ($index % 2)? '(1=0)' : '(1=1)',
			'last()'		=> count($array),
			'position()'	=> $index
		));

		// Fix = to ==
		$expression = str_replace('=', '==', $expression);
		$expression = str_replace('!==', '!=', $expression);

		// Eval if passing operator inspection
		if (!empty($expression) && preg_match('~[^-+*/%&0-9()!=<>&|]~', $expression, $m) === 0) {
			$r = eval("return({$expression});");
			if ($r === true || $r === false) {
				return $r;
			}
			return ($r == $index);
		}

		return false;
	}

	/**
	 * 
	 * @param type $array
	 * @param type $parts
	 * @param type $partIndex
	 * @param type $isRooted
	 * @param type $pathParent
	 * @return type
	 */
	function apath__matcher(&$array, $parts, $partIndex, $isRooted, $pathParent = '') {
		$part = $parts[$partIndex];

		$expression = null;
		if (preg_match('~^([^[]*)\[(.+)\]$~', $part, $match) === 1) {
			$part = $match[1];
			$expression = $match[2];
		}

		$matches = array();
		$index = 1;
		foreach ($array as $key => $value) {
			$pathCurrent = $pathParent . '/' . $key;

			$match = false;
			switch (true) {
				case $part === '':
				case $part === '*':
					$match = true;
					break;

				default:
					$match = fnmatch($part, $key, FNM_PERIOD);
			}

			if ($match && $expression) {
				$match = apath__expression($expression, $index, $array);
			}

			if ($match) {
				if ($partIndex >= count($parts) - 1) {
					$matches[$pathCurrent] = $value;
				} else if (is_array($value) && ($partIndex < count($parts) - 1)) {
					$matches += apath__matcher($value, $parts, $partIndex + 1, $isRooted, $pathCurrent);
				}
			}

			if (!$isRooted && is_array($value)) {
				$matches += apath__matcher($value, $parts, 0, $isRooted, $pathCurrent);
			}

			++$index;
		}

		return $matches;
	}

	/**
	 * Match elements in an array to an APath-syntax path specification
	 * @param Array $array
	 * @param string $path
	 * @return Array of matched elements, with fully qualified path as key
	 */
	function apath($array, $path) {
		// @todo validate global syntax

		$function = null;
		if (preg_match('~^([a-z][-a-z]+)\((.+)\)$~', $path, $match) === 1) {
			$function = $match[1];
			$path = $match[2];
		}

		$isRooted = (preg_match('~^//~', $path) === 0);
		$path = trim($path, '/');
		$path_parts = explode('/', $path);
		$result = apath__matcher($array, $path_parts, 0, $isRooted);

		// @todo handle function
		switch ($function) {
			case null:
				break;

			case 'local-name':
			case 'name':
				reset($result);
				$result = key($result);
				break;

			case 'number':
				$result = floatval(reset($result));
				break;

			case 'string':
				$result = (reset($result));
				break;

			case 'string-length':
				$result = strlen(reset($result));
				break;

			case 'count':
				$result = count($result);
				break;

			case 'sum':
				$sum = floatval(reset($result));
				while ($value = next($result)) {
					$sum += floatval($value);
				}
				$result = $sum;
				break;

			case 'avg':
				$sum = floatval(reset($result));
				while ($value = next($result)) {
					$sum += floatval($value);
				}
				$result = $sum / count($result);
				break;

			case 'min':
				$min = floatval(reset($result));
				while ($value = next($result)) {
					$min = min($min, floatval($value));
				}
				$result = $min;
				break;

			case 'max':
				$max = floatval(reset($result));
				while ($value = next($result)) {
					$max = max($max, floatval($value));
				}
				$result = $max;
				break;

			default:
				$result = array();
		}

		return $result;
	}
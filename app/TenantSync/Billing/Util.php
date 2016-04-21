<?php 

namespace TenantSync\Billing;

class Util {

	public static function studlyCase($string)
	{
		$string = str_replace(['-', '_'], ' ', $string);
		
		$string = ucwords($string);

		return str_replace(' ', '', $value);
	}

	public static function camelCase($string)
	{
		$studly = $this->studly_case($string);

		return lcfirst($studly);
	}

	public static function arrayhas($array, $keys)
	{
		if(is_string($keys)) {
			return isset($array[$keys]);
		}

		$keys = array_flip($keys);

		$keysInBothArrays = array_intersect_key($keys, $array);
		
		return count($keysInBothArrays);
	}

	public static function flatten($array)
	{
		$newArray = array();

		foreach ($array as $key => $item) {
			if (is_array($item)) {
				$newArray = $newArray + self::flatten($item);
			}
			else {
				$newArray[$key] = $item;
			}
		}

		return $newArray ;
	}
}
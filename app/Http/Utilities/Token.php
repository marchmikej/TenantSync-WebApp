<?php 

namespace App\Http\Utilities;

class Token {

	public static function create($length = 6, $entity = null)
	{
		$token = '';
		$randomString = uniqid();
		$characterArray = str_split(sha1($randomString.$entity));

		$i = 0;
		while($i < $length)
		{
			$token .= $characterArray[rand(0, 39)];
			$i++;
		}
		return $token;
	}
}
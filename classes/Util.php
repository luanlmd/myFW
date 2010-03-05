<?php
class Util
{
	//Remove spaces and international caracters from the string
	static function text2url($t)
	{
		$t = trim(strtolower(utf8_decode($t)));
		$t = ereg_replace(utf8_decode("[áàâãä]"), "a", $t);
		$t = ereg_replace(utf8_decode("[éèëê]"), "e", $t);
		$t = ereg_replace(utf8_decode("[íìïî]"), "i", $t);
		$t = ereg_replace(utf8_decode("[óòöõô]"), "o", $t);
		$t = ereg_replace(utf8_decode("[úùüû]"), "u", $t);
		$t = ereg_replace(utf8_decode("[ç]"), "c", $t);
		$t = ereg_replace(utf8_decode("[ñ]"), "n", $t);
		$t = ereg_replace(utf8_decode("[ ]"), "-", $t);
		$t = ereg_replace(utf8_decode("[^a-z0-9\+\-]"), "", $t);
		return utf8_encode($t);
	}
	
	function camelize($str, $lower = false)
	{
		$str = str_replace(' ', '', ucwords(str_replace(array('_', '-'), ' ', $str)));
		if ($lower) return lcfirst($str);
		return $str;
	}

	function uncamelize($str)
	{
		return preg_replace('@^_+|_+$@', '', strtolower(preg_replace("/([A-Z])/", "_$1", ucfirst($str))));
	}
	
	//Transform a url string to method names (url-address to urlAddress)
	static function urlToMethod($methodName)
	{
		$arr = explode("-",$methodName);
		$str = $arr[0];
		array_shift($arr);
		foreach($arr as $i)
		{
			$str .= ucwords($i);
		}
		return $str;
	}
	
	//Transform a url string to class names (url-address to UrlAddress)
	static function urlToClass($controlName)
	{
		$arr = explode("-",$controlName);
		$str = "";
		foreach($arr as $i)
		{
			$str .= ucwords($i);
		}
		return $str."Controller";
	}
	
	//Encrypt $b using the key $b
	static function crypt($a,$b) 
    {
		if ($b=='') { $b = '!2s@5#5df4$we5%g4*5t55(c*/.)'; }
		if ($a=='') return '';
			
		$retorno = ""; 
		$i = strlen($a)-1; 
		$j = strlen($b);
		    
		do { $retorno .= ($a{$i} ^ $b{$i % $j}); }
		while ($i--);
		    
		return strrev($retorno);
    }
    
    static function encrypt($string, $c = '') { return base64_encode(self::crypt($string, $c)); }
    static function decrypt($string, $c = '') { return self::crypt(base64_decode($string), $c); }
}
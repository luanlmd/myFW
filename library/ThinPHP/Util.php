<?php
namespace library\ThinPHP;

class Util
{
	static function slug($t)
	{
		$map = array(
			'/à|á|ã|â|ä|ª/' => 'a',
			'/è|é|ê|ẽ|ë/' => 'e',
			'/ì|í|î|ï/' => 'i',
			'/ò|ó|ô|õ|ø|°|º|ö/' => 'o',
			'/ù|ú|ũ|û|ü/' => 'u',
			'/ç/' => 'c',
			'/ñ/' => 'n',
			'/æ/' => 'ae',
			'/[^\w\s]/' => ' ',
			'/\s+/' => '-'
		);
		$t = preg_replace(array_keys($map), array_values($map), strtolower($t));
		return preg_replace('/^-+|-+$/','',$t);
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

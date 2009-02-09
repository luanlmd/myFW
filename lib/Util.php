<?
class Util
{

	//Remove spaces and international caracters from the string
	static function text2url($t, $hifen=true)
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
	
	//Transform a url string to method names (url-string to methodName)
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
}
?>

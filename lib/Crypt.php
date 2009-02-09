<?
class Crypt 
{
    static function stringXor($a,$b) 
    {
		if ($b=='') { $b = '!2s@5#5df4$we5%g4*5t55(c*/.)'; }
		if ($a=='') return '';
			
		$retorno = ""; 
		$i = strlen($a)-1; 
		$j = strlen($b);
		    
		do
		{
		    $retorno .= ($a{$i} ^ $b{$i % $j});
		}
		while ($i--);
		    
		return strrev($retorno);
    }
    static function encrypt($string, $c = '') 
	{
        return base64_encode(Crypt::stringXor($string, $c));
    }
    static function decrypt($string, $c = '') 
    {
        return Crypt::stringXor(base64_decode($string), $c);
    }
}
?>

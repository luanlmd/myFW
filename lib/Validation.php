<?
class Validation
{
	public static function checkEmail($email)
	{
		return eregi("^[a-z0-9_\.\-]+@[a-z0-9]{1}[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$",$email);
	}
}
?>

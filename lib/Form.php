<?
class Form
{
	public static $messages = array();
	
	public static function addMessage($message) { self::$messages[] = $message; }
	
	public static function getMessage($field)
	{
		foreach (self::$messages as $message)
		{
			if ($message->package == $field) { return $message; }
		}
		return null;
	}
	
	public static function getText($field)
	{
		foreach (self::$messages as $message)
		{
			if ($message->package == $field) { return $message->text; }
		}
		return null;
	}
	public static function hasMessages()
	{
		return !!count(self::$messages);
	}
}
?>

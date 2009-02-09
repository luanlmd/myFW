<?
class Reflect {
	static function createObject($rs, $type = "Object") 
	{
		if (!$rs) return null;
		if($data = mysqli_fetch_array($rs)) 
		{
			$object = new $type;
			foreach ($data as $k => $v)
			{
				if (!is_numeric($k)) $object->$k = $v;
			}
			return $object;
		}
		return null;
	}
	static function createObjects($rs, $type = "Object") 
	{
		if (!$rs) return null;
		$objects = array();
		while($data = mysqli_fetch_array($rs))
		{
			$object = new $type;
			foreach ($data as $k => $v)
			{
				if (!is_numeric($k)) $object->$k = $v;
			}
			$objects[] = $object;
		}
	}
}
?>

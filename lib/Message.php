<?
class Message
{
        var $type;
        var $text;
        var $package;

        function Message($type, $text = null, $package = null)
        {
                $this->type = $type;
                $this->text = $text;
                $this->package = $package;
        }

        function __toString()
        {
                return json_encode($this);
        }
}

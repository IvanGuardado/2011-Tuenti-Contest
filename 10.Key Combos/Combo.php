<?php
class Combo
{
    protected $keys;
    
    public function __construct($keys=null, $desc=null)
    {
        $this->keys =  $keys;
        $this->desc = $desc;
    }
    
    public function getKeys()
    {
        return explode(' ', $this->keys);
    }
    
    public function getDesc()
    {
        return $this->desc;
    }
}

class NullCombo extends Combo
{
    public function getDesc()
    {
        return '';
    }
}

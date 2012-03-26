<?php
class SimpleCache
{
    protected $values = array();
    protected $maxKey = 0;
    
    public function get($key)
    {
        if(isset($this->values[$key])){
            return $this->values[$key];
        }
        return null;
    }
    
    public function add($key, $value)
    {
        $key = intval($key);
        $this->maxKey = max(array($this->maxKey, $key));
        $this->values[$key] = $value;
    }
    
    public function getMaxKey()
    {
        return $this->maxKey;
    }
}

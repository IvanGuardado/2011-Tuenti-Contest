<?php
class ComboList
{
    protected $combos=array();
    protected $keyIndex;
    protected $noIndexKeys=array();
    
    public function __construct(array $keyIndex=array())
    {
        $this->keyIndex = $keyIndex;
    }
    
    public function addCombo($combo)
    {
        $this->combos[] = $combo;
        foreach($combo->getKeys() as $key){
            if(!in_array($key, $this->noIndexKeys)){
                if(!isset($this->keyIndex[$key])){
                    $this->keyIndex[$key] = array();
                }
                $this->keyIndex[$key][] = $combo;
            }
        }
    }
    
    public function findByKey($key)
    {
        if(isset($this->keyIndex[$key])){
            $newList = new ComboList();
            $newList->setNoIndexKeys(array_merge($this->noIndexKeys, array($key)));
            foreach($this->keyIndex[$key] as $combo){
                $newList->addCombo($combo);
            }
            return $newList;
        }else{
            return new EmptyComboList();
        }
    }
    
    public function setNoIndexKeys(array $noIndexKeys)
    {
        $this->noIndexKeys = $noIndexKeys;
    }
    
    public function getFirst()
    {
        return reset($this->combos);
    }
}

class EmptyComboList extends ComboList
{
    public function findByKey($key)
    {
        return new EmptyComboList();
    }
    public function getFirst()
    {
        return new NullCombo();
    }
    public function addCombo() {}
}

<?php
interface Operator
{
    function calculate($num1, $num2);
}

class AddOperator implements Operator
{
    public function calculate($num1, $num2)
    {
        return $num1 + $num2;
    }
}

class SubstractOperator implements Operator
{
    public function calculate($num1, $num2)
    {
        return $num1 - $num2;
    }
}

class MultiplyOperator implements Operator
{
    public function calculate($num1, $num2)
    {
        return $num1 * $num2;
    }
}

class OperatorFactory
{
    public static function create($metaOperator)
    {
        switch($metaOperator){
            case '=':
                return new AddOperator();
            case '#':
                return new MultiplyOperator();
            case '@':
                return new SubstractOperator();
        }
    }
}

$inputLines = file('php://stdin');
foreach($inputLines as $line){
    if(preg_match("/^\\^([=#@]) (\d) (\d)\\$$/", $line, $matches)){
        $metaOperator = $matches[1];
        $num1 = $matches[2];
        $num2 = $matches[3];
        $operator = OperatorFactory::create($metaOperator);
        echo $operator->calculate($num1, $num2);
        echo PHP_EOL;
    }
}

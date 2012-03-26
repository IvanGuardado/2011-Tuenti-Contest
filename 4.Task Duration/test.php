<?php

class Task
{
    protected $id;
    protected $duration;
    protected $dependencies = array();
    
    public function __construct($id, $duration)
    {
        $this->id = $id;
        $this->duration = $duration;
    }
    
    public function calculateExecutionTime()
    {
        $duration = $this->getDuration();
        $subTaskDuration = 0;
        foreach($this->dependencies as $taskDep){
            $time = $taskDep->calculateExecutionTime();
            if($time > $subTaskDuration){
                $subTaskDuration = $time;
            }
        }
        return $duration + $subTaskDuration;
    }
    
    public function addDependency(Task $task)
    {
        $this->dependencies[] = $task;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDuration()
    {
        return $this->duration;
    }   
}

class TaskMap
{
    protected $tasks = array();
    
    public function addTask(Task $task)
    {
        $this->tasks[$task->getId()] = $task;
    }
    
    public function getTaskById($taskId)
    {
        if(isset($this->tasks[$taskId])){
            return $this->tasks[$taskId];
        }else{
        
        }
    }
}

class TaskFileParser
{
    protected $filename;
    protected $taskCollection;
    
    public function __construct($filename)
    {
        $this->taskCollection = new TaskMap();
        $this->filename = $filename;
    }
    
    public function parse()
    {
        $taskInfo = file_get_contents($this->filename);
        if(preg_match_all('/#[^#]*/m', $taskInfo, $matches)){
            foreach($matches[0] as $fileSection){
                $lines = explode(PHP_EOL, $fileSection);
                $sectionName = array_shift($lines);
                $this->parseSection($sectionName, $lines);
            }
        }
        return $this->taskCollection;
    }
        
    protected function parseSection($sectionName, $lines)
    {
        switch($sectionName){
            case '#Task duration':
                while( ($line = array_shift($lines)) ){
                    if(preg_match('/(\d+),(\d+)/', $line, $matches)){
                        $this->taskCollection->addTask(
                            new Task($matches[1], $matches[2]));
                    }
                }
            break;
            case '#Task dependencies':
                while( ($line = array_shift($lines)) ){
                    if(preg_match('/(\d+),([\d+,]*)/', $line, $matches)){
                        $taskId = $matches[1];
                        $dependencies = explode(',', $matches[2]);
                        $task = $this->taskCollection->getTaskById($taskId);
                        foreach($dependencies as $taskDependencyId){
                            $taskDependency = $this->taskCollection->getTaskById($taskDependencyId);
                            $task->addDependency($taskDependency);
                        }
                    }
                }
            break;
        }
    }
}

$parser = new TaskFileParser('in');
$taskCollection = $parser->parse();
$tasksIds = explode(',', array_shift(file('php://stdin')));
foreach($tasksIds as $taskId){
    $task = $taskCollection->getTaskById(trim($taskId));
    echo $task->getId().'  '.$task->calculateExecutionTime().PHP_EOL;
}













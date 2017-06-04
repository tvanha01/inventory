<?php
class Department{
    private $deptId;
    private $location;

    function Department($args, $args2){
        if($args2 == 0){
            $this->parseArgs($args);
        }
        else if($args2 == 1){
            $this->parseArgs2($args);
        }
    }
    
    private function parseArgs2($args){
        $this->deptId = $args['deptId'];
        $this->location = $args['location'];
    }
    
    private function parseArgs($args){
        $this->deptId = $args[2];
        $this->location = $args[4];
    }
    
    function getLocation(){
        return $this->location;
    }

    function getDepartmentID(){
        return $this->deptId;
    }
}




?>
<?php

class Employee{
    private $name = null;
    private $deptId = null;
    private $custodianId = null;
    private $department = null;
 
    function Employee($args, $args2){
        if($args2 == 0){
             $this->parseArgs($args);
        }
        else if($args2 == 1){
            $this->parseArgs2($args);
        }
    }
    
    private function parseArgs2($args){
        $this->setName($args['name']);
        //$this->setLastName($args[20]);
        $this->setDeptId($args['deptId']);
        $this->department = new Department($args, 1);
    }
    
    private function parseArgs($args){
        $this->setName($args[19]);
        //$this->setLastName($args[20]);
        $this->setDeptId($args[2]);
    }
    
    function getName(){
        return $this->name;
    }

    function getDeptId(){
        return $this->deptId;
    }
    
    function getCustodianId(){
        return $this->custodianId;
    }
    function setName($name){
        
        $this->name = str_replace('"', "", $name);
    }
 
    function setDeptId($deptId){
        $this->deptId = $deptId;
    }
    
    function setCustodianId($custodianId){
        $this->custodianId = $custodianId;
    }
    
 
}

?>
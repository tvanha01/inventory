<?php
include "Equipment.php";
include "Staff.php";

class Computer extends Equipment{
    
    private $mfr_name;
    private $mfr_part_num;
    private $mfr_year;
    private $mfr_model;
    private $serial_num;
    private $item_desc;
    
    function Computer($args, $args2){
        if($args2 == 0){
            parent::equipment($args, $args2);
            $this->parseArgs($args);
        }
        else if($args2 == 1){
            parent::Equipment($args, $args2);
            $this->parseArgs2($args);
        }
    }
    
    private function parseArgs2($args){
        $this->mfr_name = $args['mfr_name'];
        $this->mfr_part_num = $args['mfr_part_num'];
        $this->mfr_year = $args['mfr_year'];
        $this->mfr_model = $args['mfr_model'];
        $this->serial_num = $args['serial_num'];
        $this->item_desc = $args['item_desc'];
    }
    
    private function parseArgs($args){
        $this->mfr_name = $args[5];
        $this->mfr_part_num = $args[6];
        $this->mfr_year = $args[7];
        $this->serial_num = $args[10];
        $this->item_desc = $args[3];
        $this->mfr_model = $args[8];
    }
    
    function getMfrName(){
        return $this->mfr_name;
    }
    
    function getMfrPart(){
        return $this->mfr_part_num;
    }
    
    function getMfrYear(){
        return $this->mfr_year;
    }
    
    function getMfrModel(){
        return $this->mfr_year;
    }
    
    function getSerialNum(){
        return $this->serial_num;
    }
    
    function getItemDesc(){
        return $this->item_desc;
    }
    
    function setMfrName($name){
        $this->mfr_name = $name;
    }
    
    function setPartNum($num){
        $this->mfr_part_num = $num;
        
    }
    
    function setmfrYear($year){
        $this->mfr_year = $year;
    }
    
    function setSerialNum($serial){
        $this->serial_num = $serial;
    }
    
    function setItemDesc($desc){
        $this->item_desc = $desc;
    }
    function setModel($model){
        $this->mfr_model = $model;
    }
    
 
}




?>
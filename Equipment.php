<?php
class Equipment{
    private $AssetId;
    private $total_cost;
    private $yr_srv_life;
    private $room;
    public  $employee;
    
    function Equipment($args, $args2){
        if($args2 == 0){
            $this->parseEquipArgs($args);
        }
        else if($args2 == 1){
            $this->parseEquipArgs2($args);
        }
    }
    
    private function parseEquipArgs2($args){
        $this->AssetId = $args['assetId'];
        $this->total_cost = $args['total_cost'];
        $this->yr_srv_life = $args['yr_serv_life'];
        $this->room = $args['room'];
        $this->employee = new Employee($args, 1);
        
    }
    
    private function parseEquipArgs($args){
        $this->AssetId = $args[0];
        $this->total_cost = $args[14];
        $this->yr_srv_life = $args[16];
        $this->room = $args[13];
    }
    
    function getAssetId(){
        return $this->AssetId;
    }
    function getRoom(){
        return $this->room;
    }
    function getTotalCost(){
        return $this->total_cost;
    }
    function getLifeYear(){
        return $this->yr_srv_life;
    }
    
    function setCustodian(Staff $employee){
        $this->employee = $employee;
    }
    
    function getCustodian(){
        return $this->employee;
    }
    
    function setAssetId($assetId){
        $this->assetId = $assetId;
    }
    
    function setCost($cost){
        $this->total_cost = $cost;
    }
    
    function setLife($life){
        $this->yr_srv_life = $life;
    }
    
    function setRoom($room){
        $this->room = $room;
    }
}
?>
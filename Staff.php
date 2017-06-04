<?php
class Staff extends Employee{
    private $last_update;
    private $esby_by;
    private $esbt_dt;
    private $comment;
    
    function Staff($args, $args2){
        if($args2 == 0){
            parent::Employee($args, $args2);
            $this->parseArgs($args);
        }
        else{
            parent::Employee($args, $args2);
            $this->parseArgs2($args);
            
        }
    }
    
    
    private function parseArgs2($args){
        $this->last_update = $args['last_update_by'];
        $this->esby_by = $args['esby_by'];
        $this->esbt_dt = $args['esbt_dt'];
        $this->comment = null;
        
    }
    
    private function parseArgs($args){
        $this->last_update = $args[24];
        $this->esby_by = $args[20];
        $this->esbt_dt = $args[21];
        $this->comment = null;
    }
    
    function getLastUpdate(){
        return $this->last_update;
    }
    function getLesBy(){
        return $this->esby_by;
    }
    function getEsbt_dt(){
        return $this->esbt_dt;
    }
    function getComment(){
        return $this->comment;
    }
    
    
}



?>
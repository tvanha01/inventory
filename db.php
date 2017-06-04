<?php
include '../inc/dbConnection.php';
include ("Employee.php");
include ("Department.php");
include ("Computer.php");
    
$dbConn = getDBConnection("nps_inventory");

$sql_1 = "SELECT deptId  
          FROM department
          WHERE deptId = :deptId";
        
$sql_2 = "SELECT assetId 
          FROM custodian_equipment
          WHERE assetId = :assetId";
          
$sql_3 = "SELECT assetId 
          FROM equipment
          WHERE assetId = :assetId";
          
$sql_4 = "SELECT name 
          FROM staff_member
          WHERE name = :name";
          
$sql_5 = "SELECT name 
          FROM custodian
          WHERE name = :name";
          
$sql_6 = "SELECT custodianId
          FROM custodian
          WHERE name = :name";
          

$sqlStmt = array($sql_1, $sql_2, $sql_3, $sql_4, $sql_5, $sql_6);


if($_GET['location'] != ""){
    $sql = "SELECT deptId
            FROM department
            WHERE location = :location";

    $statement = $dbConn->prepare($sql);
    $np = array();
    $np[":location"] = $_GET['location'];
    $statement->execute( $np );
    $record = $statement->fetchALL(PDO::FETCH_ASSOC);
    echo json_encode($record); 
}
else if($_GET['room'] != ""){
    $sql = "SELECT distinct(room) FROM custodian 
            NATURAL JOIN custodian_equipment NATURAL JOIN 
            department NATURAL JOIN equipment WHERE deptId = :room";
    $statement = $dbConn->prepare($sql);
    $np = array();
    $np[":room"] = $_GET['room'];
    $statement->execute( $np );
    $record = $statement->fetchALL(PDO::FETCH_ASSOC);
    echo json_encode($record); 
}
else if($_GET['search'] != ""){
    $sql= "SELECT * FROM custodian NATURAL JOIN 
          custodian_equipment NATURAL JOIN department 
          NATURAL JOIN equipment WHERE deptId = :search 
          OR name LIKE :searchable OR assetId = :search 
          OR location = :search OR room = :search 
          OR serial_num = :search OR item_desc LIKE :searchable
          OR mfr_part_num LIKE :searchable OR mfr_name = :search";
    $statement = $dbConn->prepare($sql);
    $np = array();
    $np[":search"] = $_GET['search'];
    $np[":searchable"] = "%".$_GET['search']."%";
    // $np[":searchable2"] = "%".$_GET['search']."%";
    $statement->execute( $np );
    $record = $statement->fetchALL(PDO::FETCH_ASSOC);
    echo json_encode($record); 
}
else if($_GET['bldg'] != "" || $_GET['dept'] != "" || $_GET['froom'] != ""){
    $sql = "SELECT * FROM custodian NATURAL JOIN 
          custodian_equipment NATURAL JOIN department 
          NATURAL JOIN equipment WHERE location = :dept AND
          deptId = :bldg AND room = :room2 ";
    $statement = $dbConn->prepare($sql);
    $np = array();
    $np[":bldg"] = $_GET['dept'];
    $np[":dept"] = $_GET['bldg'];
    $np[":room2"] = $_GET['froom'];
    $statement->execute( $np );
    $record = $statement->fetchALL(PDO::FETCH_ASSOC);
    echo json_encode($record);      
}


function insertEmployee(Employee $dude){
    global $dbConn, $sqlStmt;
    $np = array();
    $np[':name']  = $dude->getName();  
    if(checkDatabase($sqlStmt[4], $np) == ""){
        $sql = "INSERT INTO custodian (
                name,
                deptId
                )
                VALUES (
                :name, :deptId2
                )";
 
        $np[':deptId2'] = $dude->getDeptId();
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        $np2[':name']  = $dude->getName(); 
        $custodianId = checkDatabase($sqlStmt[5], $np2);
        return $custodianId['custodianId'];
        //return true;
    }
    else{
        $np2[':name']  = $dude->getName(); 
        $custodianId = checkDatabase($sqlStmt[5], $np2);
        return $custodianId['custodianId'];
        //return false;
    }
}

function insertStaff(Staff $dude){
    global $dbConn, $sqlStmt;
    $np = array();
    $np[':name']  = $dude->getLastUpdate();  
    if(checkDatabase($sqlStmt[3], $np) == ""){
        $sql = "INSERT INTO staff_member (
                name
                )
                VALUES (
                :name
                )";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        return true;
    }
    else{
        return false;
    }
    
}

function insertDepartment(Department $department){
    global $dbConn, $sqlStmt;
    $np = array();
    $np[':deptId']  = $department->getDepartmentID();  
    if(checkDatabase($sqlStmt[0], $np) == ""){
        $sql = "INSERT INTO department (
                deptId,
                location
                )
                VALUES (
                :deptId, :location
                )";
        $np[':location']  = $department->getLocation();  
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        return true;
        }
    else{
        return false;
    }
}

function checkDatabase($args, $np){
    global $dbConn;
    $sql = $args;
    $statement = $dbConn->prepare($sql);
    $statement->execute( $np );
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    //echo "json " . $record;
    return $record; 
}

function insertEquipment(Computer $computer){
    global $dbConn, $sqlStmt;
    $np = array();
    $np[':assetId']  = $computer->getAssetId();  
    if(checkDatabase($sqlStmt[2], $np) == ""){
        $sql = "INSERT INTO equipment (
                assetId,
                mfr_name,
                mfr_part_num,
                mfr_year,
                mfr_model,
                serial_num,
                item_desc,
                total_cost,
                yr_serv_life,
                room
                )
                VALUES (
                :assetId, :mfr_name, :mfr_part_num, :mfr_year, :mfr_model, :serial_num,
                :item_desc, :total_cost, :yr_serv_life, :room
                )";
        $np[':mfr_name']  = $computer->getMfrName();  
        $np[':mfr_part_num'] = $computer->getMfrPart();
        $np[':mfr_year']  = $computer->getMfrYear();  
        $np[':mfr_model']  = $computer->getMfrModel();  
        $np[':serial_num'] = $computer->getSerialNum();
        $np[':item_desc']  = $computer->getItemDesc();  
        $np[':total_cost']  = $computer->getTotalCost();  
        $np[':yr_serv_life'] = $computer->getLifeYear();
        $np[':room']  = $computer->getRoom(); 
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        return true;
    }
    else{
        return false;
    }
}

function insertEquipmentRecord(Computer $computer){
    global $dbConn, $sqlStmt, $custodianId;
    $staff = $computer->getCustodian();
    $np = array();
    $np[':assetId']  = $computer->getAssetId();  
    if(checkDatabase($sqlStmt[1], $np) == ""){
        $sql = "INSERT INTO custodian_equipment (
                assetId,
                custodianId,
                last_update_by,
                esby_by,
                esbt_dt,
                comment
                )
                VALUES (
                :assetId, :custodianId, :last_update_by, :esby_by, :esbt_dt, :comment
                )";
        $np[':custodianId']  = $staff->getCustodianId();  
        $np[':last_update_by'] = $staff->getLastUpdate();
        $np[':esby_by']  = $staff->getLesBy();  
        $np[':esbt_dt']  = $staff->getEsbt_dt();  
        $np[':comment'] = $staff->getComment();
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        return true;
    }
    else{
        echo false;
    }
}

function getRecords($args , $args2){
    global $dbConn;
    $sql = "SELECT * FROM custodian 
    NATURAL JOIN custodian_equipment NATURAL JOIN 
    department NATURAL JOIN equipment ";
    if($args2 == 1){
        $sql .= "WHERE assetId = :assetId"; 
    }
    $np = array();
    $np[':assetId'] = $args;
    $statement = $dbConn->prepare($sql);
    $statement->execute( $np );
    $record = $statement->fetchAll(PDO::FETCH_ASSOC);
    return parseEquipment($record);
    //return $record;
}
    function parseEquipment($record){
        $equipment = array();
        $counter = 0;
        foreach($record as $records){
            $computer = new Computer($records, 1);
            $equipment[$counter] = $computer;
            $counter++;
        }
        
        return $equipment;
    }
    
    
    function getDepartment(){
        global $dbConn;
        $sql = "SELECT DISTINCT(location) FROM department";
        $statement = $dbConn->prepare($sql);
        $statement->execute();
        $record = $statement->fetchALL(PDO::FETCH_ASSOC);
        //echo "json " . $record;
        return $record; 
    }
    
    function getUserInfo($username, $password){
        global $dbConn;
        $sql = "SELECT * FROM staff_member WHERE username = :username AND password = :password";
        $namedParameters = array();
        $namedParameters[':username'] = $username;
        $namedParameters[':password'] = $password;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetch(PDO::FETCH_ASSOC);
        return $records;
        
    }
    
    function deleteEquipment($args){
        global $dbConn;
        $sql = "DELETE FROM equipment WHERE 
                assetId = " . $args;
               
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
    }
    //$args1, $args2,$args3,$args4,$args5,$args6,$args7,$args8,$args9,$args10
    
    function updateEquipment($args1, $args2,$args3,$args4,$args5,$args6,$args7,$args8,$args9,$args10){
        global $dbConn;
        $sql = "UPDATE equipment 
                SET assetId = :assetId,
                mfr_name = :name,
                mfr_part_num = :part,
                mfr_year = :year,
                mfr_model = :model,
                serial_num = :serial,
                item_desc = :desc,
                total_cost = :cost,
                yr_serv_life = :life,
                room = :room
                WHERE assetId = :assetId";
        $np = array();
        $np[':assetId']  = $args1;
        $np[':name']  = $args2;
        $np[':part'] = $args3;
        $np[':year']  = $args4; 
        $np[':model']  = $args5;
        $np[':serial'] = $args6;
        $np[':desc']  = $args7; 
        $np[':cost']  = $args8; 
        $np[':life'] = $args9;
        $np[':room']  = $args10;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        echo " Record was updated!";

    }
    
    
    function getAvg(){
        global $dbConn;
        $sql = "SELECT avg(total_cost) as avg FROM equipment ";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;

    }
    
    function getCount(){
        global $dbConn;
        $sql = "SELECT COUNT(assetId) as count FROM equipment ";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;
        
    }
    
    
    function getSum(){
        global $dbConn;
        $sql = "SELECT SUM(total_cost) as sum FROM equipment ";
        $stmt = $dbConn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        return $record;
        
    }

?>
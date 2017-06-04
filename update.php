<?php

include 'index.php';
//session_start();

function updateRecord($record){
            echo "<form>";
            echo "<tr>";
            $computer = $record;
            echo "<td><input type = 'text' name='1' value = '" .$computer[0]->getAssetId() . "' /></td>";
            $employee = $computer[0]->getCustodian();
            echo "<td><input type = 'text' name='2' value = '"  .$employee->getName() . "' /></td>";
            echo "<td><input type = 'text' name='3' value = '"  .$computer[0]->getRoom() . "' /></td>";
            echo "<td><input type = 'text' name='4' value = '" .$computer[0]->getItemDesc() . "' /></td>";
            echo "<td><input type = 'text' name='5' value = '"  .$computer[0]->getMfrName() . "' /></td>";
            echo "<td><input type = 'text' name='6' value = '" .$computer[0]->getMfrPart() . "' /></td>";
            echo "<td><input type = 'text' name='7' value = '"  .$computer[0]->getMfrModel() . "' /></td>";
            echo "<td><input type = 'text' name='8' value = '" . $computer[0]->getSerialNum(). "' /></td>";
            echo "<td><input type = 'text' name='9' value = '" . $computer[0]->getTotalCost(). "' /></td>";
            echo "<td><input type = 'text' name='10' value = '" . $computer[0]->getMfrYear(). "' /></td>";
            echo "</tr>";
            echo "</form>";
            
        }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update</title>
    </head>
    <body>
        <form>
        <div id="page-content-wrapper">
            
           <table class="table table-striped table-bordered table table-hover ">
                <thead class="thead-inverse">
                    <tr>
                        <!--<th></th>-->
                        <!--<th>AssetId</th>-->
                        <!--<th>Name</th>-->
                        <!--<th>Room</th>-->
                        <!--<th>Item Description</th>-->
                        <!--<th>Manufacture Name</th>-->
                        <!--<th>Manufacture Part#</th>-->
                        <!--<th>Manufacture Model</th>-->
                        <!--<th>Serial Number</th>-->
                        <!--<th>Total Cost</th>-->
                        <!--<th>Manufacture Year</th>-->
                    </tr>
                </thead>
                 <?php
                    if(isset($_GET['assetId'])){
                    $record = getRecords($_GET['assetId'], 1);
                   $_SESSION['record'] = $record;
                    updateRecord($record);
                    }
                    
                    if(isset($_GET['update'])){
                        // print_r($_GET);
                        // echo "<hr>";
                        // $record = $_SESSION['record'];
                        // $record[0]->setAssetId($_GET['1']);
                        // $employee = $record[0]->getCustodian();
                        // $employee->setName($_GET['2']);
                        // $record[0]->setRoom($_GET['3']);
                        // $record[0]->setItemDesc($_GET['4']);
                        // $record[0]->setMfrName($_GET['5']);
                        // $record[0]->setPartNum($_GET['6']);
                        // $record[0]->setModel($_GET['7']);
                        // $record[0]->setSerialNum($_GET['8']);
                        // $record[0]->setCost($_GET['9']);
                        // $record[0]->setmfrYear($_GET['10']);
                        // print_r($record);
                        // $computer = new Computer($record, 1);
                        updateEquipment($_GET['1'],$_GET['2'],$_GET['3'],$_GET['4'],$_GET['5'],$_GET['6'],$_GET['7'],$_GET['8'],$_GET['9'],$_GET['10']);
                        header( "refresh:1.5; url=index.php" );
                    }
        
        
                ?>
            </table>
                <input type="submit" name="update" value ="update" />
            </form>

    </div>
    </body>
</html>
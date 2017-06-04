<?php
include 'db.php';
$totalCost = 0;
$array = explode("," , $_GET['assetId']);
$numRow = 9;
$record = array();
if(isset($_GET['assetId'])){
    for($i = 0; $i < count($array); $i++){
        if($array[$i] == "on"){
            $record[$i] = getRecords($array[$i+1], 1);
        }
        else{
            $record[$i] = getRecords($array[$i], 1);
        }
    }
}
                        
function itemRow($record, $i){
    global $totalCost;
    $totalCost += (integer) $record[0]->getTotalCost();
    echo    "<tr>";
    echo        "<td class='inner'><span>".$i."</span></td>";
    echo        "<td class='inner'><span>".$record[0]->getAssetId()."</span></td>";
    echo        "<td class='inner'><span>".$record[0]->getItemDesc()."</span></td>";
    echo        "<td class='inner'><span>".$record[0]->getSerialNum()."</span></td>";
    echo        "<td class='inner'><span>EA</span></td>";
    echo        "<td class='inner'><span>1</span></td>";
    echo        "<td class='inner'><span>".(integer) $record[0]->getTotalCost()."</span></td>";
    echo        "<td class='inner'><span>".(integer) $record[0]->getTotalCost()."</span></td>";
    echo    "</tr>";
}//endFunction

function itemRow2(){
    //print_r($record);
    echo    "<tr>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo        "<td class='inner'><span></span></td>";
    echo    "</tr>";
}//endFunction
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Property Transfer</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <style>
        .wrapper{
            border: 1px gray solid;
            padding:16px;
            font-size: 10px;
            margin: 0px auto;

        } 
        .inner{
            border: 1px gray solid;
            padding-bottom: 15px;
        }
        .title{
            border: 1px gray solid;
            padding: 20px;
        }
        
        #topRow{
            padding-bottom:40px;
        }
        #depart, #bldg{
            padding-left: 100px;
        }
        #eight{
            border: 1px solid black;
        }
        #depart2{
            padding-left: 71px;
        }
        .inner2{
            padding: 5px;
            border: 1px solid black;
        }
        #right{
            text-align: right;
            border: 1px solid black;
            padding: 10px;
        }
    
    </style>
    
    <script>
        function printPage(){
            window.print();
        }
    </script>
   
    <style type="text/css" media="print">
         .no-print{
            display: none;
        }
    </style>
    <body>
        <div class="center">
            <table class="wrapper">
                    <form>
                        <tr class="inner">
                            <th class="title" colspan="3">REQUEST FOR ISSUE/TRANSFER/TURN-IN</th>
                            <td class="inner"  id="topRow" colspan="3">1.(select one)
                            <br/>
                            Issue<input type="radio" value ="issue" name="foo"/>
                            Transfer<input type="radio" value ="Transfer" name="foo"/>
                            Turn-in<input type="radio" value ="Turn-in" name="foo"/>
                            </td>
                            <td class="inner"  id="topRow" colspan="2">2. Delivery Data
                            <br/>
                            <input type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td class="inner" colspan="4">3a. Recipient <span id="depart">b.DEPARTMENT</span><span id="bldg">c. BUILDING & ROOM #</span>
                                <br/>
                                <input type="text" />
                                <input type="text" />
                                <input type="text" />
                            </td>
                            <td class="inner" colspan="2">Purchase order #
                                <br/>
                                <input type="text" />
                            </td>
                            <td class="inner" colspan="2">5. FAST DATA # (optional)
                                <br/>
                                <input type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td class="inner" colspan="4">6a. TRANSFERER <span id="depart2">b.DEPARTMENT</span><span id="bldg">c. BUILDING & ROOM #</span>
                                <br/>
                                <input type="text" onchange="onName()" id="transName"/>
                                <!--<input type="text" />-->
                                <input id="auto" placeholder="enter here"> 
                                <input type="text" />
                            </td>
                            <td class="inner" colspan="4">7. ACCOUNTING AND FUNDING DATA (optional)
                                <br/>
                                <input type="text" />
                            </td>
                        </tr>
                        <tr>
                            <th colspan="8" id="eight">
                                <p>
                                    8. Receiving party is responsible for conducting future inventories
                                    and will be held accountable for safeguarding of received assets as outlined in <br/>
                                    NPS instruction 11016.4d. "Email completed forms to property@nps.edu." You will 
                                    be notified via email once your request is posted
                                </p>
                            </th>
                        </tr>
                        <tr>
                            <td class="inner2">(1) ITEM NO.</td>
                            <td class="inner2">(2) PROPERTY <br/> TAG</td>
                            <td class="inner2">(3) ITEM DESCRIPTION & <br/> MANUFACTURER & MODEL</td>
                            <td class="inner2">(4) SERIAL NUMBER</td>
                            <td class="inner2">(5) UNIT OF MEASURE</td>
                            <td class="inner2">(6) RECEIVED QUANTITY</td>
                            <td class="inner2">(7) UNIT PRICE <br/> (IF KNOWN)</td>
                            <td class="inner2">(8) TOTAL COST</td>
                        </tr>
                        <?php
                            
                            for($j = 0; $j < count($record); $j++){
                                itemRow($record[$j], $j + 1);
                            }
                            for($i = 0; $i < $numRow - count($record); $i++){
                                itemRow2();
                            }
                        ?>
                        <tr>
                            <td id="right" colspan="7">Total</td>
                            <td id="right"><?php echo $totalCost;?></td>
                        </tr>
                        <tr>
                            <td class="inner" colspan="2">9. TRANSFERED BY:</td>
                            <td class="inner">b. DATE</td>
                            <td class="inner" colspan="2">10. RECEIVED BY:</td>
                            <td class="inner">b. DATE</td>
                            <td class="inner">11. POSTED BY:</td>
                            <td class="inner">b. DATE</td>
                        </tr>
                        <tr>
                            <th colspan="8"><p><img src="img/NPS_logo.jpg"/>NPS PROPERTY TRANSACTION REQUEST</p></th>
                        </tr>
            </table> <!--end of table -->
                        <form style="text-align: center;">
                            <input type="button" value="Print page" onclick="printPage()" class="no-print" />
                        </form>
                    </form>
        </div>
    </body>
</html>
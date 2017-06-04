<?php
include 'db.php';
session_start();
if(!isset($_SESSION["username"])){
    $display = "none";
    $signButton = "block";
    $signOutButton = "none";
}
else{
    $display = "block";
    $signButton = "none";
    $signOutButton = "block";
}


function displayTable(){
    if(!isset($_GET['onSearch'])){
        $records = getRecords("", 0);
        //print_r($records);
        for($i = 0; $i < count($records); $i++){
            echo "<tr>";
            $computer = $records[$i];
            echo "<th scope='row'><input type ='checkbox' id='$i' value='".$computer->getAssetId()."'/></th> ";
            echo "<td>" .$computer->getAssetId() . "</td>";
            $employee = $computer->getCustodian();
            echo "<td>" .$employee->getName() . "</td>";
            echo "<td>" .$computer->getRoom() . "</td>";
            echo "<td>" .$computer->getItemDesc() . "</td>";
            echo "<td>" .$computer->getMfrName() . "</td>";
            echo "<td>" .$computer->getMfrPart() . "</td>";
            echo "<td>" .$computer->getMfrModel() . "</td>";
            echo "<td>". $computer->getSerialNum(). "</td>";
            echo "<td>". $computer->getTotalCost(). "</td>";
            echo "<td>". $computer->getMfrYear(). "</td>";
            echo "</tr>";
            }
        }
    }
    
    


    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <style>
            @import url("css/style.css");
            .input-group{
                padding-top: 50px;
                padding-left: 10px;
                background-color: gray;
                padding-right: 10px;
            }
            .trans{
                border: 1px solid black;
                background-color: transparent;
                font-size: 1.5em;

            }
            #sort{
                color: #fff;
                /*text-align: center;*/
            }
            #title{
                font-size: 1.0em;
                font-weight: bold;
                color: white;
            }
         
            #icon{
                width: 70px;
                padding-top: 320px;
                /*padding-left: 300px;*/
            }
            
            #timer{
                width: 100%;
                height: 100%;
                text-align: center;
            }
            
            #left{
                padding-left: 50px;
                padding-top: 20px;
                
            }
            
            .nav navbar-nav{
                color: white;
                float: right;
            }
            
            
            .floatRight{
                padding-top: 10px;
                padding-left: 1000px;
            }
            
            .adminButton{
                display: <?=$display?>;
            }
            
            .sign{
                display: <?=$signButton?>;
            }
            
            .sign_out{
                display: <?=$signOutButton?>;
            }

        </style>
         <script>
                /*Menu-toggle*/
                $(document).ready(function(){
                    $("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("active");
                });   
                });
                
                function hideFunction(){
                    $("#adminButton").hide();
                }
                
                function searchBldg(){
                    $("#returnDept").html("<option style='background-color: black;'>Department</option>");
                    $.ajax({
                    type: "GET",
                    url: "https://cst336-tvanha01.c9users.io/final_project/db.php",
                    dataType: "json",
                    data: { "location":$("#selectDepart").val()  },
                    success: function(data,status) {
                    //alert(data);
                    var count = Object.keys(data).length;
                    //alert(" foo " + data.deptId);
                    for(var i = 0; i < count; i++){
                        $("#returnDept").append("<option value='" + data[i].deptId + "' style='background-color: black;'>" + data[i].deptId + "</option>");
                    }
                    },
                    complete: function(data,status) { //optional, used for debugging purposes
                     // alert(status);
                  }
                });//AJAX  
                }
                
                function searchRoomNum(){
                     $("#returnRoom").html("<option style='background-color: black;'>Room</option>");
                    $.ajax({
                    type: "GET",
                    url: "https://cst336-tvanha01.c9users.io/final_project/db.php",
                    dataType: "json",
                    data: { "room":$("#returnDept").val()  },
                    success: function(data,status) {
                    //alert(data);
                    var count = Object.keys(data).length;
                    //alert(" foo " + data[0].room);
                    for(var i = 0; i < count; i++){
                        $("#returnRoom").append("<option value='" + data[i].room + "' style='background-color: black;'>" + data[i].room + "</option>");
                    }
                    },
                    complete: function(data,status) { //optional, used for debugging purposes
                      //alert(status);
                  }
                });//AJAX
                    
                }
                
                function searchDB(){
                    $("#result").html("");
                    $("#page-content-wrapper").hide();
                    $("#timer").html("<img src=img/loader.gif alt='loading' id='icon'/>");
                    if($("#onSearch").val() == ""){
                        $("#timer").html("");
                        $("#page-content-wrapper").show();
                        var temp = "<?php displayTable() ?>";
                        $("#result").html(temp);
                    }
                    else{
                        $.ajax({
                        type: "GET",
                        url: "https://cst336-tvanha01.c9users.io/final_project/db.php",
                        dataType: "json",
                        data: { "search":$("#onSearch").val()  },
                        success: function(data,status) {
                        //alert(data);
                        var count = Object.keys(data).length;
                        //alert(" foo " + data[0].room);
                        $("#page-content-wrapper").show();
                        $("#timer").html("");
                        parseJSON(data, count);
                        //alert(json);
                        },
                        complete: function(data,status) { //optional, used for debugging purposes
                        //alert(status);
                        }
                    });//AJAX
                        
                    }
                }
                
                function parseJSON(data, count){
                     for(var i = 0; i < count; i++){
                        $("#result").append("<tr><th scope='row'><input type='checkbox' id= '" + i + "' value='" + data[i].assetId + "'/></th>" +
                        "<td>" + data[i].assetId + "</td>" +
                        "<td>" + data[i].name + "</td>" +
                        "<td>" + data[i].room + "</td>" +
                        "<td>" + data[i].item_desc + "</td>" +
                        "<td>" + data[i].mfr_name + "</td>" +
                        "<td>" + data[i].mfr_part_num + "</td>" +
                        "<td>" + data[i].mfr_model + "</td>" +
                        "<td>" + data[i].serial_num + "</td>" +
                        "<td>" + data[i].total_cost + "</td>" +
                        "<td>" + data[i].mfr_year + "</td></tr>"
                        );
                        }
                }
                
                function onFilter(){
                    //alert("yaya");
                    $("#result").html("");
                    $("#page-content-wrapper").hide();
                    $("#timer").html("<img src=img/loader.gif alt='loading' id='icon'/>");
                    var bldg = $("#returnDept").val();
                    var dept = $("#selectDepart").val();
                    var room = $("#returnRoom").val();
                    var data1 = null;
                    console.log("bldg", bldg);
                    console.log("dept", dept);
                    console.log("room", room);
                 
                     $.ajax({
                    type: "GET",
                    url: "https://cst336-tvanha01.c9users.io/final_project/db.php",
                    dataType: "json",
                    data:{ "bldg": dept,
                           "dept": bldg,
                           "froom": room
                        
                    },
                    success: function(data,status) {
                    //alert(data);
                    var count = Object.keys(data).length;
                    $("#page-content-wrapper").show();
                    $("#timer").html("");
                    parseJSON(data, count);
                    // //alert(" foo " + data.deptId);
                    // for(var i = 0; i < count; i++){
                    //     $("#returnDept").append("<option value='" + data[i].deptId + "' style='background-color: black;'>" + data[i].deptId + "</option>");
                    // }
                    },
                    complete: function(data,status) { //optional, used for debugging purposes
                     //alert(status);
                  }
                });//AJAX  

                }
                
                function onPrint(){
                    // alert("check is " + $("#" + 1).val());
                    // if($("#" + 0).prop("checked")){
                    //     alert("yes something is checked");
                    //     alert($("#" + 0).val());
                    // }
                      var val = [];
                      var link = "https://cst336-tvanha01.c9users.io/final_project/excess_property.php?";
                    $(':checkbox:checked').each(function(i){
                        val[i] = $(this).val();
                        link += "assetId="+ val + "&";
                    });
                    window.location.href = link;
                }
                
                $(document).ready(function(){
                   $('#checkAll').click(function () {    
                   $('input:checkbox').prop('checked', this.checked);
                });
                    
                });
                
                function onAdd(){
                    //alert("Add");
                   // window.location.href = "https://cst336-tvanha01.c9users.io/final_project/add.php";
                }
                
                function onDelete(){
                    //alert("delete");
                    var val = [];
                       $(':checkbox:checked').each(function(i){
                        val[i] = $(this).val();
                    var confirmDelete = confirm("Do you really want to delete " + val[i] + "?");
                    if(confirmDelete){
                        window.location.href = "https://cst336-tvanha01.c9users.io/final_project/delete.php?assetId=" + val[i];
                        return true;
                    }
                    return false;

                    });
                    
                }
                function onEdit(){
                    var val = [];
                    $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    window.location.href = "https://cst336-tvanha01.c9users.io/final_project/update.php?assetId=" + val[i];


                    });
                    
                }
             
                
        </script>
    </head>
    <body >
       <div id="wrapper">
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		        <div class="container-fluid">
			        <div class="navbar-header">
    			        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        			        <span class="sr-only">Toggle navigation</span>
        			        <span class="icon-bar"></span>
        			        <span class="icon-bar"></span>
        			        <span class="icon-bar"></span>
    			        </button>
                <div  class="navbar-brand">
                    <a id="menu-toggle" href="#" class="glyphicon glyphicon-align-justify btn-menu toggle">
                        <i class="fa fa-bars"></i>
                    </a>
    				<span id="title">NPS Inventory System</span>
                </div>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<!--<li class="active"><a href="#">Home</a></li>-->
					<!--<li><a href="#about">About</a></li>-->
					
					<li>
					    <span class="adminButton">
					    <button type="button" id="delete" onclick="onDelete()">
					        <span class="glyphicon glyphicon-trash"></span>Delete
					    </button>
					    </span>
					</li>
					<li>
					   <span class="adminButton">
					<button id="edit" onclick="onEdit()">
					    <span class="glyphicon glyphicon-edit"></span>Edit
					</button>
					   </span>
					</li>
					<li class="printButton">
					    <button onclick='onPrint()'>
                            <span class="glyphicon glyphicon-print"></span> Print 
                        </button>
                    </li>
                
                    <li class="floatRight">
                        <span class="sign">
                        <form method="post" action="login.php">
                            <input type="submit" class="btn btn-primary" name="signIn" value="Sign in" />
                            <!--<i class="icon-user icon-white"></i> Sign in-->
                        </form>
                        </span>
                        <span class="sign_out">
                        <form method="post" action="signout.php">
                            <input type="submit" class="btn btn-primary" name="signout" value="Signout" />
                            <!--<i class="icon-user icon-white"></i> Sign in-->
                        </form>
                        </span>
                    </li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <nav id="spy">
            <ul class="sidebar-nav nav">
                <li>
                    <span>
                        <div class="input-group">
                            <input type="Search" class="form-control" placeholder="e.g. tag, name, etc." id="onSearch">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="searchDB()" name="onSearch"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </span>
                </li>
                <h4 id="sort">Search By:</h4>
                <li>
                    <a href="#anch1">
                        <span >
                            <form>
                                <select class="trans" onchange="searchBldg()" id="selectDepart">
                                    <option style='background-color: black;'>Building</option>
                                    <?php
                                    $department = getDepartment();
                                    foreach($department as $departments){
                                        echo "<option value='" . $departments['location'] . "' style='background-color: black;'>" . $departments['location'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#anch2">
                        <span >
                            <form>
                                <select class="trans" id="returnDept" onchange="searchRoomNum()">
                                    <option style='background-color: black;'>Department</option>
                                </select>
                            </form>
                        </span>
                    </a>
                </li>
                    <li>
                    <a href="#anch2">
                        <span >
                            <form>
                                <select class="trans" id="returnRoom">
                                    <option style='background-color: black;'>Room</option>
                                </select>
                            </form>
                        </span>
                    </a>
                </li>
                <li id="left">
                    <button type="button" class="btn btn-default" onclick="onFilter()">
                        <span class="glyphicon glyphicon-search"></span> Search
                    </button>
                </li>
                <br/>
                </br/>
                
                <li>
                    <span class="adminButton">
                        <form action="upload_file.php" method="POST"  enctype="multipart/form-data">
                            <input type="file" name="image" />
                            <input type="submit" name="onsubmit"/>
                        </form>
                    </span>
                </li>
                
                <li>
                <span style='color: white;'>Total cost: 
                <?php
                $record = getSum(); 
                echo "<h4 style = 'color: white;'>$" . $record['sum'] . "</h4>";
                ?>
                                
                </span>
                </li>
                <li><span style='color: white;'>Average: 
                <?php
                $record = getAvg(); 
                echo "<h4 style = 'color: white;'>$" . $record['avg'] . "</h4>";
                ?>
                                
                </span></li>
                <li><span style='color: white;'>Number of Equipment: 
                <?php
                $record = getCount(); 
                echo "<h4 style = 'color: white;'>" . $record['count'] . "</h4>";
                ?>
                </span>
                </li>
            </ul>
        </nav>
    </div>
    <div id="timer"></div>
    <!-- Page content -->
    <div id="page-content-wrapper">
            
           <table class="table table-striped table-bordered table table-hover ">
                <thead class="thead-inverse">
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>AssetId</th>
                        <th>Name</th>
                        <th>Room</th>
                        <th>Item Description</th>
                        <th>Manufacture Name</th>
                        <th>Manufacture Part#</th>
                        <th>Manufacture Model</th>
                        <th>Serial Number</th>
                        <th>Total Cost</th>
                        <th>Manufacture Year</th>
                    </tr>
                </thead>
                <tbody id="result">
                </tbody>
            </table>
      
    </div>
  

    </body>
</html>
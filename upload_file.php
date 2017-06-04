<?php  
include 'db.php';
   if(isset($_FILES['image'])){
       
       $file = $_FILES['image'];

       //file properties
       $file_name = $file['name'];
       $file_tmp = $file['tmp_name'];
       $file_size = $file['size'];
       $file_error = $file['error'];
       
       //work out the file extension
       
       $file_ext = explode('.', $file_name);
       $file_ext = strtolower(end($file_ext));
      
       
       $allowed = array("csv");
       
       if(in_array($file_ext, $allowed)){
           if($file_error === 0){
            $file_name_new = uniqid('', true) . "." . $file_ext; // add unique id to file
            $file_destination = '/home/ubuntu/workspace/final_project/uploaded/'. $file_name_new;
              
            if(move_uploaded_file($file_tmp, $file_destination)){
                  
                echo "File was sucessfully uploaded";
                addFileToDB($file_name_new);
                header( "refresh:1.5; url=index.php" );
                return true;
                
                  
            }
            else{
                echo "File was not uploaded try again";
                return false;
            }
            }
            else{
                echo "you have an error";
                return false;
            }
        }
        else{
            echo "file type is not allowed! CSV only!";
            return false;
       }
   }
   
   function addFileToDB($file_name_new){
        $myfile = fopen("/home/ubuntu/workspace/final_project/uploaded/" . $file_name_new, "r") or die("Unable to open file!");
            $counter = 1;
            while(!feof($myfile)){
                $Row = explode(",", fgets($myfile));
                print_r($Row);
              // echo count($Row);
              if($Row[2] == null){
                  echo "Row is empty .<br/>";
              }
              else{
                    $employee = new Employee($Row , 0); //custiodian
                    $computer = new Computer($Row , 0); //computer
                    $staff = new Staff($Row , 0); //staff 
                    $department = new Department($Row , 0);
                    if($employee->getDeptId() == ""){
                        echo $employee->getName() . " deptId is null<br/>";
                    }
                    else{
                        $staff->setCustodianId(insertEmployee($employee));
                        echo var_dump($employee) . "<br/><hr>";
                        insertStaff($staff);
                        $computer->setCustodian($staff); //custodian of the equipment
                        echo var_dump($computer) . "<br/><hr>";
                        insertEquipmentRecord($computer);
                        insertEquipment($computer);
                        insertDepartment($department);
                        $counter++;
                        unset($Row);
                    }
                }
            }
            fclose($myfile);
   }
   
   
   
   
  

?>
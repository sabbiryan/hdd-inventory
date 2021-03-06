<?php
//session_start();
//error_reporting(0);

require "../../security/DrsbdPermission.php";
$permission = new DrsbdPermission();
//exit;
$_SESSION['message']= "";

if(isset($_POST['trackNo']))
    $trackNo = $_POST['trackNo'];
if(isset($_POST['modelName']))
    $modelName = $_POST['modelName'];
//if(isset($_POST['modelNo']))
//    $modelNo =$_POST['modelNo'];
if(isset($_POST['pcb']))
    $pcb = $_POST['pcb'];
if(isset($_POST['note']))
    $note = $_POST['note'];

if(isset($_POST['mcu']))
    $mcu = $_POST['mcu'];
if(isset($_POST['smooth']))
    $smooth = $_POST['smooth'];

$dttm = date("Y-m-d H:m:s");

//page_id
if($modelName=="Western Digital")
    $page_id = "pcb-western-digital";
elseif($modelName=="Seagate")
    $page_id = "pcb-seagate";
elseif($modelName=="Samsung")
    $page_id = "pcb-samsung";
elseif($modelName=="Hitachi/IBM")
    $page_id = "pcb-hitachi-ibm";
elseif($modelName=="Fujitsu")
    $page_id = "pcb-fujitsu";
elseif($modelName=="Toshiba")
    $page_id = "pcb-toshiba";


//$mysql = mysql_connect("localhost","root","") or die(mysql_error());
//$db = mysql_select_db("DRSBD_HDD_INVENTORY") or die(mysql_error());
$result = mysqli_query($permission->dbConnect(), "UPDATE DONOR_PCB_INVENTORY SET MODEL_NAME='$modelName', PCB_NO='$pcb', NOTE='$note', UPDATE_DTTM='$dttm' WHERE TRACK_NO='$trackNo' ");

if($result){

    if($modelName == "Hitachi/IBM") {
        $final = mysqli_query($permission->dbConnect(), "UPDATE DONOR_PCB_HITACHI_IBM SET MCU='$mcu', SMOOTH='$smooth' WHERE TRACK_NO='$trackNo' ");

        if($final){
            mysqli_close($permission->dbConnect());
            $_SESSION['message'] = "Updated database successfully";
            header("Location: ../../index.php?page_id=$page_id");
            exit;
        }
        else{
            mysqli_close($permission->dbConnect());
            $_SESSION['message'] = "Row edit failed! Please try again. Otherwise contact with service provider";
            header("Location: ../../index.php?page_id=pcb_edit&id='$trackNo'");
            exit;
        }
    }

    mysqli_close($permission->dbConnect());
    $_SESSION['message'] = "Updated database successfully";
    header("Location: ../../index.php?page_id=$page_id");
}
else{
    mysqli_close($permission->dbConnect());
    $_SESSION['message'] = "Row edit failed! Please try again. Otherwise contact with service provider";
    header("Location: ../../index.php?page_id=pcb_edit&id='$trackNo'");
    exit;
}


?>
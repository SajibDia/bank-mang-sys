<?php
session_start();
include '../conn.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["status"]="Please login your account here";
    $_SESSION["code"]="warning";
    header("location: ../index.php");
    exit;
}
if (isset($_POST['transfer'])){
  $name=$_POST['name'];
  $acc=$_POST['acc'];
  $email=$_POST['email'];
  $title=$_POST['title'];
  $blnc=$_POST['blnc'];
  $newbnc=$_POST['amount'];
  $bnc1=$blnc-$newbnc;
  if($newbnc<$blnc || $blnc>500){
  $query="UPDATE accounts_info set balance='$bnc1' where account='$acc'";
  $rs1=mysqli_query($con,$query);
  if($rs1){
    date_default_timezone_set('Asia/Dhaka');
    $regisdate=date("Y-m-d");
    $tms = date("h:i:s");
    $tms1 = date("Y-m-d h:i:s");
    mysqli_query($con,"INSERT INTO account_history(account,sender,s_name,reciever,r_name,dt,tm,type,amount) VALUES('$acc','$acc','$name','null','null','$regisdate','$tms','Withdraw','$newbnc')");
    
    $_SESSION["title"]="Done";
    $_SESSION["status"]="Amount withdraw successfully";
    $_SESSION["code"]="success";
    header("location: withdraw.php");
    exit;

  }else{
    $_SESSION["title"]="Error";
    $_SESSION["status"]="Amount not withdraw";
    $_SESSION["code"]="error";
    header("location: withdraw.php");
    exit;

  }
}else{
  $_SESSION["title"]="Error";
    $_SESSION["status"]="Current Balance is low";
    $_SESSION["code"]="error";
    header("location: withdraw.php");
    exit;

}


  }
?>
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 
if(isset($_GET['id'])) {
$ConnectingDB;
$AdminId = $_GET['id'];
$sql="DELETE FROM Admins WHERE id = '$AdminId' ";
$Execute = $ConnectingDB->query($sql);


if($Execute){
    $_SESSION['SuccessMessage'] = 'Admin Deleted Successfully!';
    Redirect_to("Admins.php");
} else{
    $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
    Redirect_to("Admins.php");

}

}



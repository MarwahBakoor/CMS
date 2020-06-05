<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 
if(isset($_GET['id'])) {
$ConnectingDB;
$CategoryId = $_GET['id'];
$sql="DELETE FROM Category WHERE id = '$CategoryId' ";
$Execute = $ConnectingDB->query($sql);


if($Execute){
    $_SESSION['SuccessMessage'] = 'Category Deleted Successfully!';
    Redirect_to("Categories.php");
} else{
    $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
    Redirect_to("Categories.php");

}
}


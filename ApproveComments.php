<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 

$ConnectingDB;
$CommentId = $_GET['id'];
$Admin = $_SESSION["AdminName"];
$sql= "UPDATE comments SET status= 'ON' , approvedby ='$Admin'  
WHERE id = '$CommentId'";
$Execute = $ConnectingDB->query($sql);


if($Execute){
    $_SESSION['SuccessMessage'] = 'Comment Approved Successfully!';
    Redirect_to("Comments.php");
} else{
    $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
    Redirect_to("Comments.php");

}



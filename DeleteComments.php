<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 
if(isset($_GET['id'])) {
$ConnectingDB;
$CommentId = $_GET['id'];
$sql="DELETE FROM comments WHERE id = '$CommentId ' ";
$Execute = $ConnectingDB->query($sql);


if($Execute){
    $_SESSION['SuccessMessage'] = 'Comment Deleted Successfully!';
    Redirect_to("Comments.php");
} else{
    $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
    Redirect_to("Comments.php");

}
}
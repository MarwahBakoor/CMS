<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 

$SearchQueryParameter = $_GET['id'];

// comments submit
if (isset($_POST["CommentButton"])) {
  $CommenterName = $_POST["CommenterName"];
  $CommenterEmail = $_POST["CommenterEmail"];
  $CommentText = $_POST["CommenterThoughts"];
  date_default_timezone_set("Asia/Riyadh");
  $CurrentTime = time();
  $DateTime = strftime('%B %d,%Y %r');

  if(empty($CommenterName)||empty($CommenterEmail)){
      $_SESSION["ErrorMessage"] = "All fields must be fielled out";
      Redirect_to("FullPost.php?id=$SearchQueryParameter");
  } elseif (!filter_var($CommenterEmail, FILTER_VALIDATE_EMAIL)){
      $_SESSION["ErrorMessage"] = " Email is not correct";
      Redirect_to("FullPost.php?id=$SearchQueryParameter");
  } elseif (strlen($CommenterName)> 49){
      $_SESSION["ErrorMessage"] = "Name shouldn't be more than 50 characters";
      Redirect_to("FullPost.php?id=$SearchQueryParameter"); 
  } elseif (strlen($CommentText)> 499){
          $_SESSION["ErrorMessage"] = "The Comment shouldn't be more than 500 characters";
          Redirect_to("FullPost.php?id=$SearchQueryParameter"); 
      } else{
          $sql = " INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
          $sql .= "VALUES(:dateTime,:commenterName,:commenterEmail,:commenterThoughts,'pending','OFF',:postIdFromURL)";
          $stm = $ConnectingDB ->prepare($sql);
          $stm-> bindValue(':dateTime',$DateTime);
          $stm-> bindValue(':commenterName',$CommenterName);
          $stm-> bindValue(':commenterEmail',$CommenterEmail);
          $stm-> bindValue(':commenterThoughts',$CommentText);
          $stm-> bindvalue(':postIdFromURL',$SearchQueryParameter);
          $Execute =$stm->execute();
          var_dump($Execute);
          if($Execute){
              $_SESSION['SuccessMessage'] = 'Share your thoughts about this post';
              Redirect_to("FullPost.php?id=$SearchQueryParameter");
          } else{
              $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
              Redirect_to("FullPost.php?id=$SearchQueryParameter");

          }
      }
} // ending of Submit btn


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">

    <title>Full post</title>
</head>
<body>

    
    <!-- Navbar -->
    <div style="height:10px; background:#27aae1;"></div>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container">
                      <a href="#" class="navbar-brand"> MARWAHBAKOOR.COM</a>
                      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                      <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                          <a href="Blog.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">About Us</a>
                        </li>
                        <li class="nav-item">
                          <a href="Blog.php" class="nav-link" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">Contact Us</a>
                        </li>
                        <li class="nav-item">
                          <a href="#" class="nav-link">Features</a>
                        </li>
                        
                      </ul>
                      <ul class="navbar-nav ml-auto">
                        <form class="form-inline d-none d-sm-block" action="Blog.php" mthod="GET" >
                            <div class="form-group">
                                <input class=" form-control mr-2" name="Search" type="text" placeholder="Search here" value="" >
                                <button type="submite" class="btn btn-primary" name="SearchButton" >GO</button>
                        </div>
                        </form>

                      </ul>
                      </div>
                    </div>
                  </nav>
            <div style="height:10px; background:#27aae1;"></div>

            <!-- Navbar End-->

            <!-- HEADER START -->
                <div class="container">
                    <div class="row mt-4">

                    <!-- Main Area -->
                    <div class="col-sm-8">
                        <h2>The complete Responsive CMS Blog</h2>
                        <h1 class="lead">The complete Blog by using php by Marwah</h1>
                        <?php 
                            echo ErrorMessage();
                            echo SuccessMessage(); 
                        $ConnectingDB;
                        if (isset($_GET['SearchButton'])){
                            $Search =$_GET['Search'];
                            $sql="SELECT * FROM posts
                            WHERE datetime LIKE :search
                            OR datetime LIKE :search
                            OR title LIKE :search
                            OR category LIKE :search
                            OR post LIKE :search ORDER BY id desc";
                            $stmt = $ConnectingDB-> prepare($sql);
                            $stmt -> bindValue(":search",'%'.$Search.'%');
                            $stmt->execute();


                        } 
                        
                        else {
                        $PostIdFromURL = $_GET["id"];
                        if(!isset($PostIdFromURL)) {

                        $_SESSION['ErrorMessage'] = 'Bad Request';
                        Redirect_to('Blog.php'); 
                      }


                        $sql="SELECT * FROM posts WHERE id='$PostIdFromURL'";
                        $stmt= $ConnectingDB->query($sql);
                        $Result = $stmt->rowcount();
                        if($Result!=1){
                        $_SESSION["ErrorMessage"]="Bad Request !!";
                        Redirect_to("Blog.php?page=1");
                        }}
                        
                        while($Daterows = $stmt->fetch()){
                            $Id= $Daterows['id'];
                            $DateTime= $Daterows['datetime'];
                            $PostTitle= $Daterows['title'];
                            $Category= $Daterows['category'];
                            $admin=  $Daterows['author'];
                            $Image=  $Daterows['image'];
                            $PostText=  $Daterows['post'];


                        
                                        ?>

                        <div class="card my-5">

                        <img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid card-img-top" alt="">

                            <div class="card-body">
                                <h4><?php echo $PostTitle;?></h4>
                                <small class="card-text" > 
                                Category: <span class="text-dark">
                                 <a href="Blog.php?category=<?php echo htmlentities($Category); ?>">
                                 <?php echo htmlentities($Category); ?> 
                                 </a>
                                </span>
                                 & Written by <?php echo htmlentities($admin); ?> On 
                                 <?php echo htmlentities($DateTime); ?> </small>
                                <span style="float:right;" class="badge badge-dark text-light" >comments 
                               <?php echo AproveCommentsAcordingToPost($Id); ?>
                                </span>
                                <hr>
                                <p> <?php echo nl2br($PostText);  ?> </p>
                                
                            </div>

                        </div>


                        <?php

                        }

                        ?>
                        <!-- comment Part Start -->

                        <h2 class="Fieldcom" >Comments</h2>
                        <br> <br>
                        <?php 

                        $sql="SELECT * FROM comments 
                        WHERE Post_id='$SearchQueryParameter' AND status= 'ON' ";
                        $stmt= $ConnectingDB->query($sql);
                        
                        while($Daterows = $stmt->fetch()){
                            $Id= $Daterows['id'];
                            $DateTime= $Daterows['datetime'];
                            $Name = $Daterows['name'];
                            $Comment= $Daterows['comment'];

                          ?>

                          <div>    
                          <div class="media" style="background-color: #f7f7f7 ;">
                          <img class="d-block img-fluid" src="IMAGE/comment.png" alt="">
                          <div class="media-body ml-2">
                            <h6 class="lead"><?php echo $Name; ?></h6>

                            <p class="small"><?php echo $DateTime; ?></p>
                            <p> <?php echo $Comment; ?> </p>
                          
                          </div>
                          </div>
                          </div>
                          <hr>

                        <?php  }?>

                        <div>

                        <form  action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST">
                        <div class="card mb-3">
                        <div class="card-header ">
                        <h5 class="Fieldcom" >Thanke You for Share your thoughts about this post </h5>
                        </div>
                        <div class="card-body">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class=" input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="CommenterName" placeholder="Name" value="">
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class=" input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" name="CommenterEmail" placeholder="Email" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <textarea name="CommenterThoughts" class="form-control" cols="30" rows="6"></textarea>
                        </div>

                        <div class="">
                            <button type="submit" name="CommentButton" class="btn btn-primary">Submit</button>
                        </div>
                        </div>                        
                        </div>               
                        </form>
                        
                        
                        </div>

                    <!-- comment Part End -->

                    </div>

                <!-- Main Area End -->

                <?php require_once("footer.php") ?>
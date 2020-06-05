<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style media="screen">
  .heading{
       color: #343A40;
  }
  
  a:hover{
    text-decoration: none;
  }
  .heading:hover{
    color: #0090DB;
  }
  </style>

    <title>Blog Page</title>
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
                        <h1 class="lead mb-4 ">The complete Blog by using php by Marwah</h1>

      

                        <?php 

                        echo ErrorMessage();
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


                        }elseif(isset($_GET['category'])){
                          $Category= $_GET["category"];
                          $sql="SELECT * FROM posts WHERE category = '$Category' ORDER BY id desc";
                          $stmt = $ConnectingDB-> query($sql);

                         
                      } elseif(isset($_GET["page"])) {
                          $page= $_GET["page"];
                          
                          if($page<= 0){
                            
                            $ShowPostFrom = 0;

                          } else{

                            $ShowPostFrom = ($page*4)-4;

                          }
                          $sql="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4 ";
                          $stmt= $ConnectingDB->query($sql);

                        } else {
                        $sql="SELECT * FROM posts ORDER BY id desc";
                        $stmt= $ConnectingDB->query($sql);


                        }

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
                                <small class="text-muted"
                                
                                >Category: <span class="text-dark"> 
                                <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> 
                                <?php echo htmlentities($Category); ?> </a>
                                </span> 
                                & Written by <span class="text-dark">
                                 <a href="Profile.php?username=<?php echo htmlentities($admin); ?>"> <?php echo htmlentities($admin); ?></a>
                                 </span>
                                  On 
                                  <span class="text-dark"><?php echo htmlentities($DateTime); ?></span>
                                  </small>

                                <span style="float:right;" class="badge badge-dark text-light" >comments <?PHP 
                                     echo AproveCommentsAcordingToPost($Id);
                                ?></span>
                                <hr>
                                <p> <?php if(strlen($PostText)>150){ $PostText = substr($PostText,0,150)."...";}
                                echo htmlentities($PostText);  ?> </p>
                                <a href="FullPost.php?id=<?php echo $Id; ?>" style="float:right;"> <span class="btn btn-primary" > Read More > </span> </a>
                                
                            </div>

                        </div>

                        <?php

                        }

                        ?>

                        <nav>

                        <ul class="pagination pagination-md">
                        <?php 
                        if(isset($page)){ 
                          if($page>1){

                            ?>
                        <li class="page-item">
                          <a href="Blog.php?page=<?php echo $page-1; ?>" class="page-link">&laquo</a>
                        </li> 


                          <?php } ?>



                        <?php
                            $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM posts";
                            $stmt = $ConnectingDB->query($sql);
                            $RowPagination=$stmt->fetch();
                            $TotalPosts = array_shift($RowPagination);
                            $postPagination = ceil($TotalPosts/4); 
                            $i= 1;
                    
                            while($i<=$postPagination){
                              if ($i == $page){
                                ?>
                                <li class="page-item active ">
                                <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                              </li>
                              <?php 
                              $i++;
                              } else {
                        ?>
                        <li class="page-item">
                          <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                        
                            <?php 
                          $i++;
                          }} ?>

                          <?php 
                          if(!empty($page)){
                          if($page+1<=$postPagination){

                            ?>
                        <li class="page-item">
                          <a href="Blog.php?page=<?php echo $page+1; ?>" class="page-link">&raquo</a>
                        </li>   
                        
                        
                       <?php }}}?>
                        
                        </ul>
                        
                        </nav>

                    </div>
                <!-- Main Area End -->

<?php require_once("footer.php") ?>
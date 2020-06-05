<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php");
$_SESSION["TrackingURL"]= $_SERVER["PHP_SELF"];
Confirm_Login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title> Posts </title>
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
                          <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success" ></i>  My Profile</a>
                        </li>
                        <li class="nav-item">
                          <a href="Dashboard.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                          <a href="Posts.php" class="nav-link">Posts</a>
                        </li>
                        <li class="nav-item">
                          <a href="Categories.php" class="nav-link">Categories</a>
                        </li>
                        <li class="nav-item">
                          <a href="Admins.php" class="nav-link">Manage Admins</a>
                        </li>
                        <li class="nav-item">
                          <a href="Comments.php" class="nav-link">Comments</a>
                        </li>
                        <li class="nav-item">
                          <a href="Blog.php?page=1" class="nav-link" target="_blank">Live Blog</a>
                        </li>
                      </ul>
                      <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a href="Logout.php" class="nav-link text-danger">
                          <i class="fas fa-user-times"></i>  Logout</a></li>
                      </ul>
                      </div>
                    </div>
                  </nav>
            <div style="height:10px; background:#27aae1;"></div>

            <!-- Navbar End-->

            <!-- HEADER START -->
            <header class="bg-dark text-white py-3">

              <div class="container">
              <div class="row">
                <div class="col-md-12">
                <h1> <i class="fas fa-blog" style="color:#27aae1;"></i> Blog post </h1>
              </div>
              <div class="col-lg-3 mt-3">
                  <a href="AddNewPost.php" class="btn btn-primary btn-block" >
                  <i class="fas fa-edit"></i>  Add New Post
                </a>
              </div>
              <div class="col-lg-3 mt-3">
                  <a href="Categories.php" class="btn btn-info btn-block" >
                  <i class="fas fa-folder-plus"></i>  Add New Category
                </a>
              </div>
              <div class="col-lg-3 mt-3">
                  <a href="Admin.php" class="btn btn-warning btn-block" >
                  <i class="fas fa-user-plus"></i>  Add New Admin
                </a>
              </div>
              <div class="col-lg-3 mt-3">
                  <a href="comments.php" class="btn btn-success btn-block" >
                  <i class="fas fa-check"></i>  Approve comments
                </a>
              </div>
              </div>

            </div>
            </header>
          </br>
            <!-- HEADER END -->

            <!-- Main area -->

            <section class="container py-2 mb-4">
              <div class="row">
              <?php 
                echo ErrorMessage();
                echo SuccessMessage();?>
                <div class="col-lg-12">
                  <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr >
                      <th>#</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Date&Time</th>
                      <th>Author</th>
                      <th>Banner</th>
                      <th>comments</th>
                      <th>Action</th>
                      <th>Live Preview</th>
                    </tr>
                  </thead>
                    <?php

                      $ConnectingDB;
                      $sql = "SELECT * FROM posts ORDER BY id desc";
                      $stmt = $ConnectingDB -> query($sql);
                      $sr=0;
                      while($Daterows =  $stmt-> fetch()){
                        $Id= $Daterows['id'];
                        $DateTime= $Daterows['datetime'];
                        $PostTitle= $Daterows['title'];
                        $Category= $Daterows['category'];
                        $admin=  $Daterows['author'];
                        $Image=  $Daterows['image'];
                        $PostText=  $Daterows['post'];
                        $sr++;
                  ?>

                  <tbody> 
                  <tr>
                    <td><?php echo $sr; ?></td>
                    <td><?php if(strlen($PostTitle)>10){
                      $PostTitle = substr($PostTitle,0,8)."..";
                    }
                     echo $PostTitle; ?></td>
                    <td><?php echo $Category; ?></td>
                    <td><?php if(strlen($DateTime)>6){
                      $DateTime = substr($DateTime,0,15)."..";
                    }
                    echo $DateTime; ?></td>

                    <td><?php if(strlen($admin)>6){
                      $PostTitle = substr($admin,0,4)."..";
                    }
                    echo $admin; ?></td>
                    <td><img src="uploads/<?php echo $Image; ?>" width="150px"></td>
                    <td> 
                
                    <?php 
                            
                            $TotalComments = AproveCommentsAcordingToPost($Id);
                            if ($TotalComments>0){
                              ?>
                            <span class="badge badge-success" >
                          <?php echo $TotalComments; ?>
                            </span>
                            <?php
                            } 
?>

                  <?php 
                        
                        
                        $TotalComments = DisAproveCommentsAcordingToPost($Id);
                        if ($TotalComments>0){
                          ?>
                        <span class="badge badge-danger" >
                      <?php echo $TotalComments; ?>
                        </span>
                        <?php
                        } ?>
                </td>
                    <td>
                      <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-primary">Edit</span></a>
                      <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                    </td>
                    <td> <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blanke"><span class="btn btn-success"> Live Preview</span></a></td>
                    </tbody>
                    <?php

                      }
                    ?>


                    </tr>
                  </table>

                </div>
              </div>
            </section>

            <!-- Main area End -->

            <!-- FOOTER -->

            <footer class="bg-dark text-white">

              <div class="container">

                <div class="row">

                  <div class="div col">
                  </br>

                  <p class="lead text-center small"> Theme By | Marwah Bakoor | <span id="year"></span> &copy; ----All right Reserved. </p>
                  <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="http://jazebakram.com/coupons/" target="_blank"> This site is only used for Study purpose jazebakram.com have all the rights. no one is allow to distribute copies other then <br>&trade; jazebakram.com &trade;  Udemy ; &trade; Skillshare ; &trade; StackSkills</a></p>
                </div>
                </div>


              </div>

            </footer>
            <div style="height:10px; background:#27aae1;"></div>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>

  $('#year').text(new Date().getFullYear());



</script>

</body>
</html>
<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 
Confirm_Login();
$PostId =$_GET['id'];
if (isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "uploads/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST["Post"];
    $admain = "Marwah";
    date_default_timezone_set("Asia/Riyadh");
    $CurrentTime = time();
    $DateTime = strftime('%B %d,%Y %r');

    if(empty($PostTitle)){

        $_SESSION["ErrorMessage"] = "The post title can't be empty";
        Redirect_to("Editpost.php?id=$PostId");
    } elseif (strlen($PostTitle)<5){
        $_SESSION["ErrorMessage"] = " The post title should be more than 5 characters";
        Redirect_to("Editpost.php?id=$PostId");
    } elseif (strlen($PostTitle)> 299){
        $_SESSION["ErrorMessage"] = "The post title shouldn't be more than 300 characters";
        Redirect_to("Editpost.php?id=$PostId"); 
    } elseif (strlen($PostText)> 9999){
            $_SESSION["ErrorMessage"] = "The post Description shouldn't be more than 1000 characters";
            Redirect_to("Editpost.php?id=$PostId"); 
        } else {
          $ConnectingDB;
          if(!empty($Image)){

            $sql = " UPDATE posts 
            SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
            WHERE id='$PostId'";
          } else{
            $sql = " UPDATE posts 
            SET title='$PostTitle', category='$Category', post='$PostText'
            WHERE id='$PostId'";
          }

          $Execute = $ConnectingDB ->query($sql);
            move_uploaded_file($_FILES['Image']['tmp_name'],$Target);
        
         if($Execute){
                $_SESSION['SuccessMessage'] = 'Post with id: '.$ConnectingDB ->lastInsertId().'  Edit Successfully';
                Redirect_to("Editpost.php?id=$PostId");
            } else{
                $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
                Redirect_to("Editpost.php?id=$PostId");

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
    <link rel="stylesheet" href="css/style.css">

    <title>Edit Post</title>
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
                <h1> <i class="fas fa-edit" style="color:#27aae1;"></i> Edit Post </h1>
              </div>
              </div>
            </div>
            </header>
      
            <!-- HEADER END -->

            <!-- main area Start -->

    <section class="container py-2 mb-4">  

        <div class="rwo">

            <div class="offset-lg-2 col-lg-8"  style="min-height:200px;" >

            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
                $ConnectingDB;
                $sql= "SELECT * FROM posts WHERE id = '$PostId'";
                $stmt= $ConnectingDB-> query($sql);
                while($Daterows=$stmt->fetch()){

                    $PostTitleToEdit= $Daterows['title'];
                    $CategoryToEdit= $Daterows['category'];
                    $ImageToEdit=  $Daterows['image'];
                    $PostTextToREdit =  $Daterows['post'];


                }
            ?>

                <form action="Editpost.php?id=<?php echo $PostId ?>" method="post" enctype="multipart/form-data"> 
                    <div class="card bg-secondary text-light">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                            <label for="title"> <span class="FieldInfo "> Post Title: </span></label>
                            <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $PostTitleToEdit; ?> ">
                            </div>
                            <div class="form-group">
                            <label for="CategoryTitle"> <span class="FieldInfo "> Chose Category </span></label>
                                <select class="form-control" id="CategoryTitle" name="Category"  >
                                <?php 
                                $ConnectingDB;
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB-> query($sql);
                                while($DateRows = $stmt-> fetch()){

                                    $id = $DateRows['id'];
                                    $CategoryName = $DateRows['title'];

                                        if($CategoryName==$CategoryToEdit){
                                    ?>

                                    <option selected ><?php echo $CategoryToEdit; ?> </option>

                                    <?php   } else { ?>
                                    <option> <?php echo $CategoryName; ?> </option>
                                    <?php }}?>
                                    
                

                                </select>
                            </div>
                            <div class="form-group">
                            <span>Existing Image</span>
                            <img class="mb-2" src="uploads/<?php echo $ImageToEdit; ?>" alt="<?php echo $ImageToEdit; ?>" width=150px >
                            <div class="custom-file">
                                <input class="custom-file-input" type="file" name="Image" id="imageSelect" src="uploads/<?php echo $ImageToEdit; ?>">
                                <label for= "imageSelect" class="custom-file-label" > Select image </label>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="post"> <span class="FieldInfo"> Post: </span></label>
                                <textarea name="Post" id="post" class="form-control" cols="30" rows="10" ><?php echo $PostTextToREdit; ?></textarea>
                            </div>
                            <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-info btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Publish
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>

                </form>
             </div>
        </div>


     </section>



            <!-- main area End -->
            
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
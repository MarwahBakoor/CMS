<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php 
Confirm_Login();
if (isset($_POST["Submit"])) {
    $Category = $_POST["CategoryTitle"];
    $admain = $_SESSION["Username"];
    date_default_timezone_set("Asia/Riyadh");
    $CurrentTime = time();
    $DateTime = strftime('%B %d,%Y %r');
    if(empty($Category)){

        $_SESSION["ErrorMessage"] = "All field must be filled out";
        Redirect_to("Categories.php");
    } elseif (strlen($Category)<3){
        $_SESSION["ErrorMessage"] = "Category title should be more than 2 characters";
        Redirect_to("Categories.php");

    } elseif (strlen($Category)> 49){
        $_SESSION["ErrorMessage"] = "Category title shouldn't be more than 50 characters";
        Redirect_to("Categories.php"); } 
        else{

            $sql = " INSERT INTO Category(title,author,datetime)";
            $sql .= "VALUES(:CategoryName,:admainName,:dateTime)";
            $stm = $ConnectingDB ->prepare($sql);
            $stm-> bindValue(':CategoryName',$Category);
            $stm-> bindValue(':admainName',$admain);
            $stm-> bindValue(':dateTime',$DateTime);
            $Execute =$stm->execute();

            if($Execute){
                $_SESSION['SuccessMessage'] = 'Category with id: '.$ConnectingDB ->lastInsertId().'  Added Successfully';
                Redirect_to("Categories.php");
            } else{
                $_SESSION["ErrorMessage"] = "Somthing went wrong. Try Again";
                Redirect_to("Categories.php");

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

    <title>Categories</title>
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
                <h1> <i class="fas fa-edit" style="color:#27aae1;"></i> Manage Categories </h1>
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
            ?>

                <form action="Categories.php" method="post"> 
                    <div class="card bg-secondary text-light">
                        <div class="card-header">

                        <h1> Add new Categorie </h1> 

                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                            <label for="title"> <span class="FieldInfo "> Categroy Title: </span></label>
                            <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
                <h2 class="my-5">Existing Categories</h2>
          <table  class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No. </th>
                <th>Date&Time</th>
                <th>Category Name</th>
                <th>Creator Name</th>
                <th>Action</th>
              </tr>
            </thead>
         
            <?php 

                $ConnectingDB;
                $sql = "SELECT * FROM Category";
                $Execute= $ConnectingDB->query($sql);
                $SrNo = 0;

                while ($DataRows = $Execute->fetch()) {

                    $CategorytId = $DataRows['id'];
                    $DateTimeOfCategory = $DataRows['datetime'];
                    $CategoryTitle = $DataRows['title'];
                    $Author = $DataRows['author'];
                    $SrNo++

                ?>

                <tbody>
                <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                <td><?php echo htmlentities($DateTimeOfCategory); ?></td>
                <td><?php echo htmlentities($CategoryTitle); ?></td>
                <td><?php echo htmlentities($Author ); ?></td>
                <td> <a href="DeleteCategoris.php?id=<?php echo $CategorytId; ?>" class="btn btn-danger">Delete</a>  </td>
                </tr>
                </tbody>

                <?php } ?><tbody>
            
         
          </table>

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
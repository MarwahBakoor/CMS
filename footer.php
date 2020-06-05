                                          <!-- Side Area -->
                                          <div class="col-sm-4">

                          <div class="card mt-4">
                          <div class="card-body">

                            <img src="image/startblog.png" class="d-block img-fluid mb-3" alt="">
                            <div class="text-center">

                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                            </div>
                          </div> 
                          </div>
                          <br>
                          <div class="card">
                            <div class="card-header bg-dark text-light">
                              <h2 class="lead">Sign Up !</h2>
                            </div>
                            <div class="card-body">
                              <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
                              <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                              <div class="input-group mb-3">
                                <input type="text" class="form-control" name="" placeholder="Enter your email"value="">
                                <div class="input-group-append">
                                  <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <br>
                          <div class="card">
                            <div class="card-header bg-dark text-light">
                              <h2 class="lead">Categories</h2>
                              </div>
                              <div class="card-body">
                              <?php 

                              $ConnectingDB;
                              $sql="SELECT * FROM category ORDER BY id desc";
                              $stmt = $ConnectingDB->query($sql);
                              while( $DataRows =  $stmt->fetch() ){
                                $CategoryId = $DataRows["id"];
                                $CategoryName=$DataRows["title"];

                                ?>

                                <a href="Blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading"> <?php echo $CategoryName; ?></span> </a><br>

                                <?php
                              } ?>

                          </div>
                          </div>
                          <br>
                          <div class="card">
                            <div class="card-header bg-dark text-light">
                              <h2 class="lead">Recent Posts</h2>
                              </div>
                              <div class="card-body">
                              <?php 

                              $ConnectingDB;
                              $sql="SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                              $stmt = $ConnectingDB->query($sql);
                              while( $DataRows =  $stmt->fetch() ){
                                $PostId = $DataRows["id"];
                                $PostTitle=$DataRows["title"];
                                $PostImage = $DataRows["image"];
                                $PostDate = $DataRows["datetime"];

                                ?>

                          <div class="media">
                          <img src="uploads/<?php echo htmlentities($PostImage);?>" class="d-block img-fluid align-self-start"  width="90" height="94" alt="">
                          <div class="media-body ml-2">
                          <a style="text-decoration:none;"href="FullPost.php?id=<?php echo htmlentities($PostId) ; ?>" target="_blank">  <h6 class="lead"><?php echo htmlentities($PostTitle); ?></h6> </a>
                          <p class="small"><?php echo htmlentities($DateTime); ?></p>
                          </div>
                          </div>
                          <hr>
                                <?php
                              } ?>

                          </div>
                          </div>

                          </div>


                          </div>
                          <!-- Side Area End -->


              

                    </div>
                </div>

                <!-- Main Area -->



                        
                
                <!-- Main Area End -->   

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
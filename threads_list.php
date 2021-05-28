<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>I-forum</title>
</head>

<body>
<?php include'partials/dbconnect.php';?>
    <?php include'partials/_navbar.php';?>
    <?php
    $id=$_GET['catid'];
     $sql="    SELECT * FROM `categories` WHERE categories_id=$id ";
     $result=mysqli_query($conn,$sql);
     while($row=mysqli_fetch_assoc($result)){
    $catname=$row['categories_name'];
    $catdesc=$row['categories_description'];
    
     }
    ?>

    <?php
        $showalert=false;
        $method = $_SERVER['REQUEST_METHOD'];
    if ($method=='POST'){
        //  Insert into thread into DB
        $th_title= $_POST['title'];
        $th_desc=  $_POST['desc'];
        
        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);
        
        $sno= $_POST['sno'];
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`)
         VALUES ( '$th_title', '$th_desc', '$id', '$sno', CURRENT_TIMESTAMP())";
        $result=mysqli_query($conn,$sql);
        $showalert=true;
        if($showalert){
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added! Please wait until community reply back.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }

    }
    ?>
    <!-- Category container here -->

    <div class="container my-3" id="ques">
        <div class="jumbotron">
            <h1 class="display-4 my-4">Welcome to <?php echo $catname;?> Forums</h1>
            <p class="lead"> <?php echo $catdesc;?> .</p>
            <hr class="my-4">
            <p>This is peer to peer forum is for sharing knowledge with each other.<br>
            <h5> READ FORUM RULES:</h5><br>
            1. No Spam / Advertising / Self-promote in the forums in not allowed.<br>
            2. Do not post copyright-infringing material. <br>
            3. Do not post “offensive” posts, links or images.<br>
            4. Do not cross post questions.<br>
            5. Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo '<div class="container">
            <h1 class="py-2">Ask a Question</h1>
            <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Promblem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
                    <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                        possible.</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" placeholder="Comment Your Question">Ellabotate Your
                        Concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                <button type="submit" class="btn btn-success">Submit</button>
            </form><br>
        </div>';
    }

    else{
        echo '
        <div class="container">
        <h1 class="py-2">Ask a Question</h1>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>FAIL!</strong> You are not login. Please ensure your login!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        </div>';
    }
?>
    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
    $id=$_GET['catid'];
     $sql="   SELECT * FROM `threads` WHERE thread_cat_id=$id ";
     $result=mysqli_query($conn,$sql);
     $noResult=true;
     while($row=mysqli_fetch_assoc($result)){
         $noResult = false;
        $id=$row['thread_id'];
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_time=$row['timestamp'];
        $thread_user_id=$row['thread_user_id'];
        $sql2 = "SELECT user_email FROM `users` where sno=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
     

      echo  '<div class="media my-2">
            <img src= "img/userdefault.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">'.
        '<h5 class="mt-0"><a class="text-dark" href="thread.php?thread_id='. $id .'">'. $title .'</a></h5>
               '.$desc.'</div>'.'<p class="font-weight-bold my-0 py-2">Asked by:-'. $row2['user_email'].' at  '.$thread_time.
               '</p>'.
        '</div>';
    }

    // echo var_dump($noResult);
    if($noResult){
        echo '
        <b><div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Comment Found</p>
        <p class="lead">Be the first person to ask a question.</p>
        </div>
      </div>';
    }
    ?>
    </div>
    <!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< FORM>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->


    </div>
    <?php include'partials/footer.php';?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script> -->

</body>

</html>
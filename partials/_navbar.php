<?php
// $showerror="false";
session_start();
echo' 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/forum">I-Forum</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="\forum">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php/">About</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       Top Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';


      $sql = "SELECT categories_name, categories_id  FROM `categories` LIMIT 3";
      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result)){

echo  '<a class="dropdown-item" href="threads_list.php?catid='.$row['categories_id'].'"> '.$row['categories_name'].'</a>';
      
}
    echo '</div>
  </li>
    <li class="nav-item">
      <a class="nav-link " href="contact.php/">Contact</a>
    </li>
  </ul>
  <div class="row mx-2">';

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ! THIS IS CONDITIONAL WHEN WE REQUIRED WE USE
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
echo '<form class="form-inline my-2 my-lg-0" method = "get" action="search.php">
<input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
<p class="text-light my-0 mx-2"> '. $_SESSION['useremail'] .'</p> </form>
<a href="partials/logout.php" class="btn btn-outline-success ml-2">Logout</a>';

}

else{
echo'<form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginmodel">Login</button>
  <button class="btn btn-outline-success mx-2"data-toggle="modal" data-target="#signupmodal">Signup</button>';
}
echo  '</div>
      </div>
      </nav>';

include'partials/loginmodal.php';
include'partials/signupmodal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
      echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
      <strong>Success!</strong> You can now login.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
}
// else{
//   if($showerror==true){
//   echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
//   <strong>Fail!</strong> Check your username or password.
//   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//     <span aria-hidden="true">&times;</span>
//   </button>
// </div>';
// }
// }
?>
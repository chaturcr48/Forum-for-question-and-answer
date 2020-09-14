<?php
session_start();
if(isset($_SESSION['loggedin'])){
    $loggedin=true;
}
else{
    $loggedin=false;
}
echo'
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/CHATUR_PHP/forum/home.php">iForum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/CHATUR_PHP/forum/home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/CHATUR_PHP/forum/about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Top Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    $sql="SELECT category_name,category_id  FROM `categories` limit 10";
                    $result=mysqli_query($conn, $sql);
                    while($row=mysqli_fetch_assoc($result)){
                      echo '<a class="dropdown-item" href="/CHATUR_PHP/forum/partials/threadlist.php?catid='.$row['category_id'].'">'. $row['category_name'] .'</a>';
                    }
                echo '</div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Contacts</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 mr-1 my-sm-0" type="submit">Search</button>
        </form>';
        if(!$loggedin){
            echo '<button type="button" class="primary btn-primary btn-secondary rounded mx-2 p-1" data-toggle="modal" data-target="#loginModal">Login</button>
            <button type="button" class="primary btn-primary btn-secondary rounded p-1" data-toggle="modal" data-target="#signupModal">SignUp</button>
        ';}
        if($loggedin){
            echo '
            <span class="ml-1 text-success"><b>Welcome '.$_SESSION['username'].'</b></span>
            <a class="nav-link" href="/CHATUR_PHP/forum/partials/logout.php"><button type="button" class="primary btn-primary btn-secondary rounded">Logout</button></a>';
        }
    echo '</div>
</nav>';
?>

<?php include "login.php"; ?>
<?php include "signup.php"; ?>


<?php
    if(isset($_GET['userexist'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Error!</strong> Username already exist.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
<?php
    if(isset($_GET['signupsuccess'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Success!</strong> You successfully signed up, Login to continue.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
<?php
    if(isset($_GET['passunmatch'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Error!</strong> Password do not match, Please try again to signup.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
<?php
    if(isset($_GET['loginsuccess'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Success!</strong> You logged in successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
<?php
    if(isset($_GET['notsignedup'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Error!</strong> Signup first to login.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>
<?php
    if(isset($_GET['incorrectpass'])){
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <strong>Error!</strong> Incorrect Password.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
?>

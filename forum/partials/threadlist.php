<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    include "dbconnect.php";
    $id = $_GET['catid'];
    $ptitle = $_POST['prob_title'];
    $ptitle = str_replace("<", "&lt;", $ptitle);
    $ptitle = str_replace(">", "&gt;", $ptitle);
    $pdesc = $_POST['prob_desc'];
    $pdesc = str_replace("<", "&lt;", $pdesc);
    $pdesc = str_replace(">", "&gt;", $pdesc);
    $sno = $_POST['sno'];
    $sql="INSERT INTO `thread_table` (`thread_id`, `thread_title`, `thread_description`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (NULL, '$ptitle', '$pdesc', '$id', '$sno', current_timestamp());";
    $result=mysqli_query($conn, $sql);
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Threads</title>
</head>

<body>
    <?php include "dbconnect.php"; ?>
    <?php include "_header.php"; ?>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if($result){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your question added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        else{
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Error in arising question!</strong> Login first to place question.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    }
    ?>
    <?php
        $id=$_GET['catid'];
        $sql="SELECT * FROM `categories` WHERE category_id = $id";
        $result=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_assoc($result)){
            $catname=$row['category_name'];
            $catdesc=$row['category_description'];
        }
    ?>
    <div class="container mt-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?></h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="container">
        <h3>Browse Questions</h3>
        <ul class="list-unstyled">
            <?php

            $id=$_GET['catid'];
            $sql="SELECT * FROM `thread_table` WHERE thread_cat_id=$id";
            $result=mysqli_query($conn, $sql);
            $noResult=true;
            while($row=mysqli_fetch_assoc($result)){
                $noResult=false;
                $title=$row['thread_title'];
                $desc=$row['thread_description'];
                $id2=$row['thread_id'];
                $time=$row['timestamp'];
                $thread_user_id=$row['thread_user_id'];
                $sql2="SELECT `username` FROM `user` WHERE sno='$thread_user_id'";
                $result2=mysqli_query($conn, $sql2);
                $row2=mysqli_fetch_assoc($result2);
                $username=$row2['username'];
                echo '<li class="media mt-3">
                <img src="https://carismartes.com.br/assets/global/images/avatars/avatar7_big@2x.png" width="50px" class="mr-3" alt="Avatar">
                <div class="media-body">
                <h5 class="mt-0 mb-1"><a class="text-dark" href="/CHATUR_PHP/forum/thread.php?threadid='.$id2.'">'.$title.'</a></h5>
                '.$desc.'
                </div>
                <p class="mb-0">Asked by <strong>'.$username.'</strong> at '.$time.'</p>
            </li>';
            }
            ?>
        </ul>
        <?php
        
            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid" style="padding: 1rem 0rem;">
                    <div class="container">
                  <h1 class="display-4" style="font-size: 2rem;">No question found yet</h1>
                  <p class="lead">Be the first person to question.</p>
                </div>
              </div>';
            }
            if(isset($_SESSION['loggedin'])){
                echo '<form action="/CHATUR_PHP/forum/partials/threadlist.php?catid='.$id.'" method="post" class="bg-light my-2">
                <div class="form-group">
                  <label style="margin-bottom: 0rem;" for="prob_title">Problem title</label>
                  <input type="text" class="form-control" id="prob_title" name="prob_title">
                  <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                </div>
                <div class="form-group">
                    <label class="mb-0" for="prob_desc">Problem description</label>
                    <textarea class="form-control" id="prob_desc" name="prob_desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Problem</button>
              </form>';
            }
            else{
                echo '<div class="jumbotron jumbotron-fluid" style="padding: 1rem 0rem;">
                    <div class="container">
                  <h1 class="display-4" style="font-size: 2rem;">You are not logged in</h1>
                  <p class="lead">Login to post a question.</p>
                </div>
              </div>';
            }
        ?>
    </div>
    
    <?php include "footer.php"; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>
<!-- <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post"> -->
<!-- <form action="/CHATUR_PHP/forum/partials/threadlist.php?catid='.$id.'" method="post" class="bg-light my-2"> -->
<!-- <img src="img/avatar2.png" alt="Avatar" class=""avatar card-img-top"> -->

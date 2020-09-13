<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    include "partials/dbconnect.php";
    $id = $_GET['threadid'];
    $comment = $_POST['comment'];
    $sno = $_POST['sno'];
    $sql="INSERT INTO `comments` (`comment_id`, `comment`, `thread_id`, `comment_by`, `comment_time`) VALUES (NULL, '$comment', '$id', '$sno', current_timestamp())";
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
    <?php include "partials/_header.php"; ?>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if($result){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment added successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        else{
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Insertion Error!</strong> Login to post your comment.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    }
    ?>
    <?php include "partials/dbconnect.php"; ?>
    <?php
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `thread_table` WHERE thread_id = $id";
        $result=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_assoc($result)){
            $title=$row['thread_title'];
            $desc=$row['thread_description'];
        }
    ?>
    <div class="container mt-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p><b>show more</b></p>
        </div>
    </div>
    <div class="container">
        <h3>Comments</h3>
        <ul class="list-unstyled">
            <?php

            $id=$_GET['threadid'];
            $sql="SELECT * FROM `comments` WHERE thread_id = $id";
            $result=mysqli_query($conn, $sql);
            $ok=true;
            while($row=mysqli_fetch_assoc($result)){
                $ok=false;
                $comment=$row['comment'];
                $comment_by=$row['comment_by'];
                $id2=$row['thread_id'];
                $time=$row['comment_time'];
                $thread_user_id=$row['comment_by'];
                $sql2="SELECT `username` FROM `user` WHERE sno='$thread_user_id'";
                $result2=mysqli_query($conn, $sql2);
                $row2=mysqli_fetch_assoc($result2);
                echo '<li class="media mt-3">
                <img src="https://carismartes.com.br/assets/global/images/avatars/avatar7_big@2x.png" width="50px" class="mr-3" alt="...">
                <div class="media-body">
                    <h5 class="mt-0 mb-1"><a class="text-dark" href="/CHATUR_PHP/forum/thread.php?threadid='.$id2.'">'.$row2['username'].'&nbsp&nbsp'.$time.'</a></h5>
                    '.$comment.'
                </div>
            </li>';
            }
            ?>
        </ul>
        <?php
        
            if($ok){
                echo '<div class="jumbotron jumbotron-fluid" style="padding: 1rem 0rem;">
                    <div class="container">
                  <h1 class="display-4" style="font-size: 2rem;">No comments found yet</h1>
                  <p class="lead">Be the first person to comment.</p>
                </div>
              </div>';
            }
            if(isset($_SESSION['loggedin'])){
                echo '<form action="/CHATUR_PHP/forum/thread.php?threadid='.$id.'" method="post" class="bg-light my-2">
                <div class="form-group">
                    <label class="mb-0" for="comment">Add a comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
              </form>';
            }
            else{
                echo '<div class="jumbotron jumbotron-fluid" style="padding: 1rem 0rem;">
                    <div class="container">
                  <h1 class="display-4" style="font-size: 2rem;">You are not logged in</h1>
                  <p class="lead">Login to post a comment.</p>
                </div>
              </div>';
            }
        ?>
    </div>
    <?php include "partials/footer.php"; ?>
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
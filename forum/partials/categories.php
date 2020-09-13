<?php include "dbconnect.php"; ?>

<div class="container mt-4 text-center">
    <h2>iForum categories</h2>
    <div class="row row-cols-1 row-cols-md-3">
        <?php

            $sql="SELECT * FROM `categories`";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)){
            echo '<div class="col mb-4">
                    <div class="card h-100">
                        <img src="img/s'.$row['category_id'].'.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="/CHATUR_PHP/forum/partials/threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></h5>
                            <p class="card-text">'.substr($row['category_description'], 0, 90).'...</p>
                        </div>
                        <div class="container mb-3"><a href="/CHATUR_PHP/forum/partials/threadlist.php?catid='.$row['category_id'].'" class="btn btn-primary" style="width:132px;">View threads</a>
                        </div>
                    </div>
                </div>';
            }
        ?>
    </div>
</div>
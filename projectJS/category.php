<?php

    $conn = mysqli_connect("localhost","root","","todojs");
    $cat = mysqli_real_escape_string($conn, $_POST['category']);     
    $queryCat = "SELECT * FROM category WHERE name = '$cat'";

    if($resultCat = mysqli_query($conn,$queryCat))
    {
        while($row = mysqli_fetch_array($resultCat))
        {
            $img = '<img src="'.$row['image'].'" class="imgCat" alt="alternatetext"><br>';
            echo  $img;
        }
    }
    else
    {
        echo -1;
    }
    mysqli_close($conn);   
?>
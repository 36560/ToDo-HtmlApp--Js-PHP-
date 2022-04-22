<?php
    $conn = mysqli_connect("localhost","root","","todojs");

    $taskName = mysqli_real_escape_string($conn, $_POST['name']);
    $dateTask = mysqli_real_escape_string($conn, $_POST['dateTask']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);     
    $currentUserId = mysqli_real_escape_string($conn,$_POST["userId"]);
    $taskID = mysqli_real_escape_string($conn,$_POST["idTask"]);

    $query = "UPDATE tasks SET name = '$taskName', description='$desc', category_name='$cat', date_task='$dateTask' WHERE id = $taskID";

    if (mysqli_query($conn, $query)) 
    {
        $queryCat = "SELECT * FROM category WHERE name = '$cat'";
        if($resultCat = mysqli_query($conn,$queryCat))
        {
            while($row = mysqli_fetch_array($resultCat))
            {
                $img = '<img src="'.$row['image'].'" class="imgCat" alt="alternatetext"><br>';
                echo  $img;
            }
        }
    } 
    else
    {
        echo -1;
    }
    
    mysqli_close($conn);       
?>




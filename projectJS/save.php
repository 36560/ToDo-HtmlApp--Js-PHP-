<?php

        $conn = mysqli_connect("localhost","root","","todojs");

        $taskName = mysqli_real_escape_string($conn, $_POST['name']);
        $dateTask = mysqli_real_escape_string($conn, $_POST['dateTask']);
        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
        $cat = mysqli_real_escape_string($conn, $_POST['category']);     
        $currentUserId = mysqli_real_escape_string($conn,$_POST["userId"]);

        $query = "INSERT INTO tasks (name,description,category_name,date_task,id_user) VALUES ('$taskName','$desc','$cat','$dateTask','$currentUserId')";
            
        if (mysqli_query($conn, $query)) 
        {
            $last_id = $conn->insert_id;
             
            echo $last_id;
        } 
        else 
        {
           echo -1;
        }

        mysqli_close($conn);
?>


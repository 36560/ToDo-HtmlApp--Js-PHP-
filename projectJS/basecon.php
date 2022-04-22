<?php

    $conn = mysqli_connect("localhost","root","","todojs");


    if(isset($_SESSION["username"]))
    {
        header("location:main.php");
    }

    if(isset($_POST["register"]))
    {
        if(empty($_POST["username"]) || empty($_POST["pass"]))
        {
            $_SESSION["error"] = "It's quite empty here :C";
        }
        else
        {        
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0)
            {
                $_SESSION["error"] = "Choose a different login";      
            }
            else
            {
                $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $query = "INSERT INTO users(username,password) VALUES ('$username','$pass')";

                if(mysqli_query($conn, $query))
                {
                    $_SESSION["success"] = "Successful register :)";   
                }
                else
                {
                    $_SESSION["error"] = "Unsuccessful register :C";
                }
            }
        }
    }
    if(isset($_POST["login"]))
    {
        if(empty($_POST["login"]) || empty($_POST["pass"]))
        {
            $_SESSION["error"] = "It's quite empty here :C";
        }
        else
        {
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $pass = mysqli_real_escape_string($conn, $_POST["pass"]);

            $query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_array($result))
                {
                    if(password_verify($pass, $row["password"]))
                    {
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $row["id"];
                        header("location:main.php");
                    }
                    else
                    {
                        $_SESSION["error"] = "Wrong password";      
                    }
                }
            }
            else
            {
                $_SESSION["error"] = "Wrong login";      
            }
        }
    }
?>
<?php

    $conn = mysqli_connect("localhost","root","","todojs");
    session_start();

    if(!isset($_SESSION["username"]))
    {
        header("location:index.php?action=login");
    }

    $username = $_SESSION["username"];
    $currentUser = $_SESSION["id"];
?>

<!DOCTYPE html>
<html>
    <head>
    <title>ToDo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
      integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>       
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>    
        <link rel="stylesheet" href="style.css">    
    
        <script type='text/javascript'>
            function deleteTask(id)
            {
                $.ajax
                ({
                    url: "delete.php",
                    type: "POST",
                    data: 
                    {
                        idTask: id,
                    },
                    cache: false,
                    success: function(data) 
                    {               
                        if(data == 1)     
                        {
                            $(".row" + id).fadeOut('slow');   
                        }
                        else
                        {                  
                            $('.errorInfo').html(data);
                        }
                    },
                    error: function(xhr, status, error) 
                    {
                        console.error(xhr);              
                    }            
                });                        
            }                    
    
            function getData(currentUser,option, divid)
            {
                var ajaxDisplay = document.getElementById(divid);
                var today = new Date();
                var month = today.getMonth() + 1
                var day = today.getDay();
                var year = today.getFullYear();

                var todayDate = today.toISOString().split('T')[0];
                var key = $("#searchKey").val();

                $.ajax({
                    url: 'read.php',
                    type: "POST",
                    data:
                    {
                        option: option,
                        currentUser: currentUser,
                        todayDate: todayDate,
                        searchKey: key
                    },
                    cache: false,
                    success: function(data) 
                    {   
                        ajaxDisplay.innerHTML = data;                     
                    },
                    error: function(xhr, status, error) 
                    {
                    }
                });
            }
            function deleteChecked()
            {
                var ajaxDisplay = document.getElementById('displaydata');
                var today = new Date();
                var month = today.getMonth() + 1
                var day = today.getDay();
                var year = today.getFullYear();
                var todayDate = today.toISOString().split('T')[0];

                $.ajax({
                    url: 'deleteChecked.php',
                    type: "POST",
                    data:
                    {
                        todayDate: todayDate,
                        currentUser: <?php echo $currentUser; ?>                 
                    },
                    cache: false,
                    success: function(data) 
                    {                     
                        if(data==1)   
                        {
                            ajaxDisplay.innerHTML = data;  
                            document.getElementById("terminedInfo").style.display = "block";  
                        }
                        else
                        {
                            console.log(data);
                        }
                                           
                    },
                    error: function(xhr, status, error) 
                    {
                    
                    }
                });
            }

        </script>
    </head>

<body onload="welcome(); getData(<?php echo $currentUser ?>, '0', 'displaydata')">

        <?php include('navbar.php'); ?>           
        
        <!-- Page Wrapper -->
    <div style="background: url(https://images.pexels.com/photos/9429448/pexels-photo-9429448.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940)" id="bgImage" class="page-holder bg-cover">
        <div id="terminedInfo" class="toast-container position-fixed">
        <div class="toast show bg-dark text-light">
            <div class="toast-header text-light">
                Info from ToDo App
                <button type="button" class="btn-close btnToast" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Checked task from past was deleted
            </div>
            </div>
        </div>
       
        <div class ="container">
            <div class="container py-5">
                <header class="text-center text-dark py-5">

                <p id="welcomeInfo" class ="container-fluid mt-4"></p>                     
   
                    <div>
                        <button class="btn btn-dark btnAdd" id="addBtn" onclick="openForm()">Add<i class="fab fa-medrt"></i></button>
                    </div>
                </header>   

                <div class="errorInfo">
                <?php
                    if(isset($_GET["error"]) && isset($_SESSION["error"]))
                    {
                        $err = $_SESSION["error"];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                    }
                ?>
            </div>
        </div>
        <div class="fullscreen-container">
                <!-- ADD form -->
                <div class="text-dark">
                    <div class="form-popup" id="addForm">
                        <form class="add-edit-container" method="POST">
                            <h1>Add task</h1>

                            <label>Title</label> <br/>
                            <input type="text" id="nameTask" name="nameTask" class="form-control" required/> 
                            <br/>

                            <label>Deadline</label><br/>
                            <input type="date" id="dateTask" name="dateTask" class="form-control" value=""/> 
                            <br/>

                            <label>Description</label> <br/>
                            <input type="text" id="descTask" name="descTask" class="form-control"/> 
                            <br/>
                            
                            <label>Category</label> <br/>
                                <?php 
                                    $query = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $query);       
                                    
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        while($row = mysqli_fetch_array($result))
                                        {
                                           echo '<label><input type="radio" name="categoryTask" id="categoryTask" value="'.$row["name"].'" checked><img src="'.$row["image"].'" class="imgCat" alt="alternatetext">'.$row['name'].'</label><br>';                                       
                                        }
                                    }                         
                                ?>                           
                            <br/>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success btn-block" onclick="addTask()" id="add">Add</button>
                                <button type="button" class="btn btn-warning btn-block" onclick="closeForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>   
                <!-- EDIT form -->
                <div class="text-dark">
                    <div class="form-popup" id="editForm">
                        <form class="add-edit-container" method="POST">
                            <h1>Edit task</h1>

                            <input type="text" name="idTaskEdit" id="idTaskEdit" class="form-control" hidden/> 
                            <br/>

                            <label>Title</label> <br/>
                            <input type="text" name="nameTaskEdit" id="nameTaskEdit" class="form-control" required/> 
                            <br/>

                            <label>Date</label><br/>
                            <input type="date" name="dateTaskEdit" id="dateTaskEdit" class="form-control" value=""/> 
                            <br/>

                            <label>Description</label> <br/>
                            <input type="text" name="descTaskEdit" id="descTaskEdit" class="form-control"/> 
                            <br/>                        
                             
                            <label>Category</label> <br/>
                                <?php 

                                    $query = "SELECT * FROM category";
                                    $result = mysqli_query($conn, $query);                             
                                    
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                        while($row = mysqli_fetch_array($result))
                                        {                                                                               
                                            echo '<label><input type="radio" name="categoryEdit" id="'.$row["name"].'" value="'.$row["name"].'" required><img src="'.$row["image"].'" class="imgCat" alt="alternatetext">'.$row['name'].'</label><br>';                               
                                        }
                                    }                         
                                ?>                           
                            <br/>                            
                            <div class="d-grid gap-2">
                                <button type="button"  class="btn btn-success btn-block" onclick="editTask()">Edit</button>
                                <button type="button" class="btn btn-warning btn-block" onclick="closeEditForm()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>  
        </div>

            <select class="form-select bg-dark text-light" id="groupOption" aria-label="Default select example"  onchange="getData(<?php echo $currentUser ?>, this.value, 'displaydata')">
                <option value ="0" selected>All</option>
                <option value="1">Today</option>
                <option value="2">Future</option>
                <option value="3">Past or indefinite</option>
            </select>

        <div id="displaydata">
        </div>

        <script>deleteChecked();</script>
                
    </div>            
    </div>

<script type='text/javascript'>

    $("#searchKey").on('keyup', function()
    {
        var value = $(this).val().toLowerCase();
        document.getElementById("groupOption").value = '0';
        getData(<?php echo $currentUser ?>,'0','displaydata');
    });

    function welcome()
    {
        var login = '<?php echo $username; ?>';
        var today = new Date();
        var time = today.getHours();
        var wel;

        if(time>4 && time<12)
        {
            wel = "Good morning, ";
        }
        else if (time>=12 && time<18)
        {
            wel = "Have a nice day, ";
        }
        else if(time>=18 && time<22)
        {
            wel = "Good Evening, ";
        }
        else
        {
            wel = "Good night, ";
        }
        $('#welcomeInfo').text(wel+login)
    }
    function addTask()
    {
        var name = $('#nameTask').val();
        var dateTask = $('#dateTask').val();
        var desc = $('#descTask').val();
        var category = $('input[name="categoryTask"]:checked').val();
        var userId = <?php echo $_SESSION["id"] ?>;

        if (name && category )
        {
            $.ajax
            ({
            url: "save.php",
            type: "POST",
            data: 
            {
                name: name,
                dateTask: dateTask,
                desc: desc,
                category: category,
                userId: userId
            },
            cache: false,
            success: function(data) 
            {        
                if(data == -1)   
                {
                    closeForm();
                    var err = "Nieudane dodawanie :C";
                    var error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'+err+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.errorInfo').html(error);
                }
                else
                {       
                    $(".displayData").fadeOut(200);
                    closeForm();
                    var option = $('#groupOption').val();
                    getData(<?php echo $currentUser ?>,option,'displaydata')
                    $(".displayData").fadeIn(300);                  
                }         
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);
            }            
            });  
        }    
        else
        {
            $('#nameTask').attr("placeholder", "Set value");
        }        
    } 
    $(document).on("click", ".rowCh", function()
    {        
        var checked;        
        var color = "#0d01018a";
        var colorGr = "#567d1498";
        var bodyColor = $(this).parent().css("text-decoration");

        if($(this).parent().find('td').eq(6).find('i').hasClass('checking'))
        {
            //UNCHECKED             
            $(this).parent().fadeOut(300);
            $(this).parent().css({
                    "background-color": color,
            });
            $(this).parent().fadeIn(300);
            $(this).parent().find('td').eq(6).html("<i class=''>");
            checked = '0';                                    
        }                            
        else
        {      
            $(this).parent().fadeOut(300);
            $(this).parent().css({
                    "background-color": colorGr,                    
            });
            $(this).parent().fadeIn(300);
            $(this).parent().find('td').eq(6).html("<i class='fa fa-check checking'>");
            checked = '1';                                         
        }
        $.ajax
        ({
            url: "check.php",
            type: "POST",
            data: 
            {
                checked: checked,
                idTask: idTask
            },
            cache: false,
            success: function(data) 
            {
                if(data==-1)
                {
                    var err = "Nieudane odhaczenie zadania :C"
                    var error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'+err+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.errorInfo').html(error);
                }
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);
            }  
        });         
    });
    function openForm() 
    {
        $(".fullscreen-container").fadeTo(200, 1);
        document.getElementById("addForm").style.display = "block";                       
    }
    function closeForm() 
    {        
        document.getElementById("addForm").style.display = "none";
        $(".fullscreen-container").fadeOut(300);          
    }
    function openEditForm(id,nameTask,descTask,cat,dateTask) 
    {    
        document.getElementById("idTaskEdit").value = id;      
        document.getElementById("nameTaskEdit").value = nameTask;
        document.getElementById("descTaskEdit").value = descTask;
        document.getElementById("dateTaskEdit").value = dateTask;
        document.getElementById(cat).checked = true;    

        $(".fullscreen-container").fadeTo(200, 1);
        document.getElementById("editForm").style.display = "block";        
    }   
    function editTask()
    {
        var name = $('#nameTaskEdit').val();
        var dateTask = $('#dateTaskEdit').val();
        var desc = $('#descTaskEdit').val();
        var category = $('input[name="categoryEdit"]:checked').val();
        var idTask = $('#idTaskEdit').val();
        var userId = <?php echo $_SESSION["id"] ?>;

        $(".row" + idTask).fadeOut(100);
        $.ajax
        ({
            url: "edit.php",
            type: "POST",
            data: 
            {
                name: name, 
                dateTask: dateTask,
                desc: desc,
                category: category,
                idTask: idTask,
                userId: userId
            },
            cache: false,
            success: function(data) 
            {
                if(data == -1)
                {
                    closeEditForm();
                    var err = "Nieudane edytowanie :C"
                    var error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'+err+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.errorInfo').html(error);
                }
                else
                {
                    closeEditForm();    
                    $(".displayData").fadeOut(200);
                    closeForm();
                    var option = $('#groupOption').val();
                    getData(<?php echo $currentUser ?>,option,'displaydata')
                    $(".displayData").fadeIn(300);        
                }    
            },
            error: function(xhr, status, error) 
            {
                console.error(xhr);
            }  
        });       

        $(".row" + idTask).fadeIn(300);              
    }
    var idTask;
    function clickedRow(id)
    {
        idTask = id;
    }
    function closeEditForm() 
    {        
        $(".fullscreen-container").fadeOut(300);      
        document.getElementById("editForm").style.display = "none";
    }
    function sortTable(n) 
    {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("taskTable");
        switching = true;
        dir = "asc"; 

        if(n==0)
        {
            document.getElementById("sortName").style.color="#07ad15";
            document.getElementById("sortCat").style.color="white";
            document.getElementById("sortDate").style.color="white";
        }
        if(n==1)
        {
            document.getElementById("sortName").style.color="white";
            document.getElementById("sortCat").style.color="white";
            document.getElementById("sortDate").style.color="#07ad15";
        }
        if(n==3)
        {
            document.getElementById("sortName").style.color="white";
            document.getElementById("sortCat").style.color="#07ad15";
            document.getElementById("sortDate").style.color="white";
        }

        while (switching)
        {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) 
            {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                if (dir == "asc") 
                {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase())
                    {
                        shouldSwitch= true;
                        break;
                    }
                } 
                else if (dir == "desc") 
                {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
                    {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch)
            {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;      
            } 
            else 
            {
                if (switchcount == 0 && dir == "asc") 
                {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

</body>
</html>
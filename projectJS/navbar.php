<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="main.php">To Do List</a>
    <button class="navbar-toggler" id="searchBtn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php 
            if(isset($_SESSION["username"]))
            {                   
                echo '<li class="nav-item"><a class="nav-item nav-link" href="logout.php">Log out</a></li>';
            }
            else
            {
                echo '<li class="nav-item"><a class="nav-item nav-link" href="index.php?action=login">Log in</a></li>
                <li class="nav-item"><a class="nav-item nav-link" href="index.php?action=register">Register</a></li>';
            }                              
          ?>
      </ul>
      <?php 
      if(isset($_SESSION["username"]))
      { ?>
        <form class="d-flex">    
        
        <div class="input-container">
        <i class="fab fa-searchengin icon"></i>

          <input class="input-field me-2 bg-dark text-light searchKey" type="search" name="searchKey" id="searchKey" placeholder="Searcher" aria-label="Search">
          
          </div>
        </form>
        <?php 
      }
      ?>

    </div>
  </div>
</nav>
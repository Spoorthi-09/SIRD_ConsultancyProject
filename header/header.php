<nav class="navbar navbar-expand-lg navbar-light bg-light ">

<a class="navbar-brand" href="#">
<?php
  if ( file_exists("../images/lion_resize.png" ) && is_dir( "../images"  ) ) 
    {
      ?>
    <img src="../images/lion_resize.png" width="30" height="30" alt="no img" >
<?php
      }else{
  ?>
        <img src="images/lion_resize.png" width="30" height="30" alt="no img" >
<?php }?>

  </a>  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
      <?php
        if(isset($_SESSION['St_user_id']))
        {
          if ( file_exists("../stateLevel/state_index.html" ) && is_dir( "../stateLevel"  ) ) 
          {
      ?>
          <a class="nav-link" href="../stateLevel/state_index.html">Home <span class="sr-only">(current)</span></a>
      <?php
          }else{
      ?>
          <a class="nav-link" href="stateLevel/state_index.html">Home <span class="sr-only">(current)</span></a>
         <?php
       }
        }else{
      ?>
        <a class="nav-link" href="user_index.html">Home <span class="sr-only">(current)</span></a>
       <?php }?>
      </li>
    </ul>
    <?php 
    if ( file_exists("../stateLevel/state_index.html" ) && is_dir( "../stateLevel"  ) ) 
          {
      ?>
      <a href="../logout.php"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
      <?php
          }else{
      ?>
      <a href="logout.php"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
         <?php
       }?>
  </div>
</nav>

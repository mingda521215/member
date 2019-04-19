<?php 
session_start();

require_once("./../includes/connMysql.php");

//繫結登入會員資料
$query_RecMember = "SELECT * FROM memberdata WHERE m_username='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);
$row_RecMember = $RecMember->fetch_assoc();

?>
  <header class="main-header">

    <!-- Logo -->
    <a href="member_center.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Ta</b>Yo</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TaYo</b> System</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs">嗨：<?php echo $row_RecMember["m_username"];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              

              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if($_SESSION["memberLevel"] == "member"){
                      echo "<a href='./member_update.php' class='btn btn-default btn-flat'>Profile</a>";
                  }else{
                      echo "<a href='./member_update.php?id=$mid' class='btn btn-default btn-flat'>Profile</a>";
                  }?>
                  <!-- <a href="./member_update.php" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <a href="?logout=true" class="btn btn-default btn-flat">登出系統</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
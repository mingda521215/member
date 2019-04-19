<?php
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
  unset($_SESSION["loginMember"]);
  unset($_SESSION["memberLevel"]);
  header("Location: ../index.php");
}
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        
        <div class="pull-left info">
          <p><?php echo $mname; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header" align="center"><h5>功能主選單</h5></li>
        <li>
          <a href="member_center.php">
            <i class="fa fa-dashboard"></i> <span>後台首頁</span>
            
          </a>
        </li> 
        <li>
          <a href="owner.php">
            <i class="fa fa-home"></i> <span>屋主資訊</span>
            
          </a>
        </li>
        <li>
          <a href="owner_search.php">
            <i class="fa fa-car"></i> <span>車位查詢</span>
            
          </a>
        </li>
        <li <?php if($_SESSION["memberLevel"] == "member"){ echo 'class="hide"';}?>>
          <a href="member_admin.php">
            <i class="fa fa-cubes"></i> <span>用戶中心</span>
            
          </a>
        </li>    
    </section>
    <!-- /.sidebar -->
  </aside>
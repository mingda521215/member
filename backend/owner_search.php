<?php
require_once("../includes/connMysql.php");
session_start();

// 繫結登入會員資料
$query_RecMember = "SELECT * FROM memberdata WHERE m_username='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);
$row_RecMember = $RecMember->fetch_assoc();

?>
<!-- load the backend_header -->
<?php include_once("layouts/backend_header.php"); ?>
<!-- load the backend_header_menu -->
<?php include_once 'layouts/backend_header_menu.php'; ?>
<!-- load the side menu. contains the logo and sidebar -->
<?php include_once('layouts/backend_side_menu.php'); ?>
<?php

if( empty($_SESSION['login']) ) header( "Location: ./login.php" );
if( !empty($_POST["searchtype"]) ) {
  switch( $_POST["searchtype"] ) {
    case "s_bike":
    $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `bike1` = '$_POST[search]' OR `bike2` = '$_POST[search]' OR `bike3` = '$_POST[search]' OR `bike4` = '$_POST[search]';");
    break;
    case "s_car":
    $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `car1` = '$_POST[search]' OR `car2` = '$_POST[search]' OR `car3` = '$_POST[search]' OR `car4` = '$_POST[search]';");
    break;
    default:
    ERROR("search type failed!");
  }
}


?>
<body class="hold-transition skin-blue">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        停車位查詢
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> 首頁</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">本頁面</li>
        </ol>
      </section>
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <!-- Search bar -->
            <div class="box box-primary">

              <div class="box-body box-profile">
                <br>
                
              
  <!-- <fieldset disabled> -->

    <form id="search" action="owner_search.php" method="post">
      <div class="form-group">
        <div class="has-success">
          <div class="checkbox" name="searchtype">
            <label>
              <input name="searchtype" type="checkbox" id="checkboxSuccess" value="s_bike"">
              查詢機車停車格
            </label>
          </div>
        </div>
        <div class="has-warning">
          <div class="checkbox">
            <label>
              <input name="searchtype" type="checkbox" id="checkboxWarning" value="s_car">
              汽車停車格查詢
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword2" class="sr-only">Password</label>
          <input name="search" type="text" class="form-control" id="search" placeholder="請輸入編號">
        </div>
        <button type="submit" name="submit" class="btn btn-default">執行查詢</button>
    </form>
    

              <?php

              if( isset($_POST["searchtype"]) ) {
              $select_owner_by_id = mysqli_query($db_link, $result);
                  while($row = mysqli_fetch_array($result)){
                  $house_num    = $row['house_num'];
                  $fee_code     = $row['fee_code'];
                  $house_status = $row['house_status'];
                  $address      = $row['address'];
                  $owner_name   = $row['owner_name'];
                  $owner_phone  = $row['owner_phone'];
                  $lessee_name  = $row['lessee_name'];
                  $lessee_phone = $row['lessee_phone'];
                  $car1         = $row['car1'];
                  $car2         = $row['car2'];
                  $car3         = $row['car3'];
                  $bike1        = $row['bike1'];
                  $bike2        = $row['bike2'];
                  $bike3        = $row['bike3'];
                  $bike4        = $row['bike4'];
                  
                  }
              }

              ?>
              
                    <form>
                      <table class="table table-striped" align="center">
                        <thead>
                          <tr>
                            <th>車位編號</th>
                            <th>管理代碼</th>
                            <th>屋主姓名</th>
                            <th>屋主電話</th>
                            <th>租客姓名</th>
                            <th>租客電話</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?php echo $_POST['search']; ?></td>
                            <td><?php echo $fee_code; ?></td>
                            <td><?php echo $owner_name; ?></td>
                            <td><?php echo $owner_phone; ?></td>
                            <td><?php echo $lessee_name; ?></td>
                            <td><?php echo $lessee_phone; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </section>
      </div>
      <!-- load the footer -->
      <?php include_once("layouts/backend_footer.php") ?>
    </div>
<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<!-- <script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
</script>    --> 
</body>
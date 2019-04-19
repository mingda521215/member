<?php
require_once("../includes/connMysql.php");
session_start();

?>

<!-- load the backend_header -->
<?php include_once("layouts/backend_header.php"); ?>

<!-- load the backend_header_menu -->
<?php include_once 'layouts/backend_header_menu.php'; ?>

<!-- load the side menu. contains the logo and sidebar -->
<?php include_once('layouts/backend_side_menu.php'); ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        屋主資訊
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="member_center.php"><i class="fa fa-dashboard"></i> 首頁</a></li>
        <li class="active">屋主資訊</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <br/><h3 class="box-title">本資料受個資法保護，嚴禁任何私人轉載及運用！</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>管理序號</th>
                  <th>門牌</th>
                  <th>屋主</th>
                  <th>屋主電話</th>
                  <th>承租人</th>
                  <th>承租人電話</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>

<?php
  $query = "SELECT * FROM fee2 ORDER BY fee_code DESC";
  $select_owner = mysqli_query($db_link, $query);

  while($row = mysqli_fetch_assoc($select_owner)){
    $fee_code    = $row['fee_code'];
    $address     = $row['address'];
    $owner_name  = $row['owner_name'];
    $owner_phone = $row['owner_phone'];
    $lessee_name = $row['lessee_name'];
    $lessee_phone = $row['lessee_phone'];    
    
?>
                <tr>
                  <?php echo "<td>$fee_code</td>"; ?>
                  <?php echo "<td>$address</td>"; ?>
                  <?php echo "<td>$owner_name</td>"; ?>
                  <?php echo "<td>$owner_phone</td>"; ?>
                  <?php echo "<td>$lessee_name</td>"; ?>
                  <?php echo "<td>$lessee_phone</td>"; ?>
                  
                  
                  <?php echo "<td><a href='edit_owner.php?p_id=" . $fee_code . "'>編輯</a></td>"; ?>
                </tr>
               <?php  }?>
                </tbody>
              
              </table>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <!-- load the footer -->
<?php include_once("layouts/backend_footer.php") ?> 
  
</div>

<!-- </body> -->
<!-- ./wrapper -->

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
<script>
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
</script>
</body>
<!-- load the footer -->
<?php 
// close database connection
$mysqli->close();
 ?>

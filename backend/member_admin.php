<?php 
require_once("./../includes/connMysql.php");
session_start();

//檢查權限是否足夠
if($_SESSION["memberLevel"]=="member"){
	header("Location: member_center.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	header("Location: ../index.php");
}
//刪除會員
if(isset($_GET["action"])&&($_GET["action"]=="delete")){
	$query_delMember = "DELETE FROM memberdata WHERE m_id=?";
	$stmt=$db_link->prepare($query_delMember);
	$stmt->bind_param("i", $_GET["id"]);
	$stmt->execute();
	$stmt->close();
	//重新導向回到主畫面
	header("Location: member_admin.php");
}
//選取管理員資料
$query_RecMember = "SELECT m_id, m_name, m_logintime FROM memberdata WHERE m_username=?";
$stmt = $db_link->prepare($query_RecMember);
$stmt->bind_param("s", $_SESSION["loginMember"]);
$stmt->execute();
$stmt->bind_result($mid, $mname, $mlogintime);
$stmt->fetch();
$stmt->close();

//選取所有一般會員資料
//預設每頁筆數
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$query_RecMember1 = "SELECT * FROM memberdata WHERE m_level<>'admin' ORDER BY m_jointime DESC";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecMember1 = $query_RecMember1." LIMIT {$startRow_records}, {$pageRow_records}";
//以加上限制顯示筆數的SQL敘述句查詢資料到 $resultMember 中
$RecMember1 = $db_link->query($query_limit_RecMember1);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_resultMember 中
$all_RecMember1 = $db_link->query($query_RecMember1);
//計算總筆數
$total_records = $all_RecMember1->num_rows;
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
?>

<!-- load the backend_header -->
<?php include_once("layouts/backend_header.php"); ?>

<!-- load the backend_header_menu -->
<?php include_once 'layouts/backend_header_menu.php'; ?>

<!-- load the side menu. contains the logo and sidebar -->
<?php include_once("layouts/backend_side_menu.php"); ?>


<script language="javascript">
function deletesure(){
    if (confirm('\n您確定要刪除這個會員嗎?\n刪除後無法恢復!\n')) return true;
    return false;
}
</script>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        系統後台
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首頁</a></li>
        <li class="active">用戶中心</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">管理員資訊</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>姓名</th>
                    <th>帳號</th>
                    <th>加入時間</th>
                    <th>上次登入</th>
                    <th>登入次數</th>
                    <th>操作</th>
                  </tr>
                </thead>

                <?php while($row_RecMember1 = $RecMember1->fetch_assoc()){ ?>
                
                <tbody>
                    <tr>  
                      <td><?php echo $row_RecMember1["m_name"]; ?></td>
                      <td><?php echo $row_RecMember1["m_username"]; ?></td>
                      <td><?php echo $row_RecMember1["m_jointime"]; ?></td>
                      <td><?php echo $row_RecMember1["m_logintime"]; ?></td>
                      <td><?php echo $row_RecMember1["m_login"]; ?></td>
                      <td width="10%" align="center" bgcolor="#FFFFFF"><p><a href='member_adminupdate.php?id=<?php echo $row_RecMember1["m_id"]; ?>'>修改</a> / 
                      <a href='?action=delete&id=<?php echo $row_RecMember["m_id"]; ?>' onClick="return deletesure();">刪除</a></p></td>
                    </tr>
                </tbody>
              <?php }?>
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
<!-- load the footer -->
<?php include_once("layouts/backend_footer.php") ?>

</div>
</body>

<!-- jQuery 3 -->
<script src="./../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="./../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="./../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="./../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./../dist/js/demo.js"></script>
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
<?php  $db_link->close(); ?>

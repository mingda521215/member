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

<?php

  if(isset($_GET['p_id'])){
    $the_post_id = $_GET['p_id'];
  }

  $query = "SELECT * FROM fee2 WHERE fee_code = $the_post_id" ;
  $select_owner_by_id = mysqli_query($db_link, $query);

  while($row = mysqli_fetch_assoc($select_owner_by_id)){
  $house_num    = $row['house_num'];
  $fee_code     = $row['fee_code'];
  $house_status = $row['house_status'];
  $address      = $row['address'];
  $house_reside = $row['house_reside'];
  $owner_name   = $row['owner_name'];
  $owner_phone  = $row['owner_phone'];
  $lessee_name  = $row['lessee_name'];
  $lessee_phone = $row['lessee_phone'];
  $car1         = $row['car1'];      
  $car2         = $row['car2'];      
  $car3         = $row['car3'];      
 }


 if(isset($_POST['update_post'])) {

    // $fee_code     =  ($_POST['fee_code']);
    $house_status =  ($_POST['house_status']);
    $owner_name   =  ($_POST['owner_name']);
    $owner_phone  =  ($_POST['owner_phone']);
    $lessee_name  =  ($_POST['lessee_name']);
    $lessee_phone =  ($_POST['lessee_phone']);  
    $house_reside =  ($_POST['house_reside']);  

    $fee_code = mysqli_real_escape_string($db_link, $fee_code);

    $update_query = "UPDATE fee2 SET ";
    $update_query .="house_status  = '{$house_status}', ";
    $update_query .="owner_name = '{$owner_name}', ";
    $update_query .="owner_phone = '{$owner_phone}', ";
    $update_query .="lessee_name = '{$lessee_name}', ";
    $update_query .="lessee_phone   = '{$lessee_phone}', ";
    $update_query .="house_reside   = '{$house_reside}' ";
    $update_query .= "WHERE fee_code = {$the_post_id} ";
    
    $update_result = mysqli_query($db_link,$update_query);

    
    
    
    if (mysqli_affected_rows($db_link) > 0) {
      echo "<script language='javascript'>window.alert('資料已執行完成更新！！'); </script>";
    }else{
      echo "<script language='javascript'>window.alert('資料並未更新！！'); </script>";
    }
}


?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        住戶基本資料表
      </h1>
      <ol class="breadcrumb">
        <li><a href="./member_center.php"><i class="fa fa-dashboard"></i> 首頁</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">本頁</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->
                          
              <?php
              /*
                $id = $row_RecUser["fee_code"];

                echo "<div align='center'>";
                if ($row_RecUser["avatar"] == 0) {
                  echo "<img src='uploads/user".$id.".jpg' width='128px'>";
                }else{
                  echo "<img src='uploads/profiledefault.jpg' width='128px'>";
                }
                  // echo "<p>".$row_RecMember['m_username']."</p>";
                echo "<hr/>";
                echo "</div>";
                  
                echo "<div class='form-group'>
                <form action='' method='POST' enctype='multipart/form-data'>
                    <label><input type='file' name='file'></label>
                    <button type='submit' name='submit'>UPLOAD</button>
                    </div>
                    </form><hr/>"
                 */
                 ?>

              <h3 class="profile-username text-center"><?php echo $owner_name; ?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>房屋序號</b> <a class="pull-right"><?php echo $house_num; ?></a>
                </li>
                <li class="list-group-item">
                  <b>管理序號</b> <a class="pull-right"><?php echo $fee_code; ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">備註</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              
              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          
            <div class="box box-primary">
              <div class="content">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">管理序號</label>
                    <div class="col-xs-4">
                      <input type="text" class="form-control" name="fee_code" id="" placeholder="Fee Code" value="<?php echo $fee_code; ?>" disabled>
                    </div>
                    <label class="col-sm-2 control-label">居住人數</label>
                      <div class="col-xs-4">
                        <select class="form-control" name="house_reside" id="">
                          <option value="<?php echo $house_reside; ?>"><?php echo $house_reside; ?></option>
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                          <option>6</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">屋主姓名</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="owner_name" id="inputName" placeholder="Name" value="<?php echo $owner_name; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">電郵信箱</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label">使用狀況</label>
                  <div class="col-sm-10">
          <select class="form-control" name="house_status" id="">
            <option value="<?php echo $house_status; ?>"><?php echo $house_status; ?></option>
            <?php
              if($house_status == '自住') {
              echo "<option value='出租'>出租</option>";
              } else {
              echo "<option value='自住'>自住</option>";
              }
            ?>
          </select>
                  </div>
                  
                </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">屋主電話</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="owner_phone" id="" placeholder="Name" value="<?php echo $owner_phone; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">承租人姓名</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="lessee_name" id="" placeholder="Name" value="<?php echo $lessee_name; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">承租人電話</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="lessee_phone" id="" placeholder="Name" value="<?php echo $lessee_phone; ?>">
                    </div>
                  </div>
                  <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">汽車位編號</label>
                
                  <div class="rcol-sm-10">
                    <div class="col-xs-3">
                      <input type="text" class="form-control" name="car1" placeholder="無" value="<?php echo $car1; ?>">
                    </div>
                    <div class="col-xs-3">
                      <input type="text" class="form-control" name="car2" placeholder="無" value="<?php echo $car2; ?>">
                    </div>
                    <div class="col-xs-3">
                      <input type="text" class="form-control" name="car3" placeholder="無" value="<?php echo $car3; ?>">
                    </div>
                  </div>
                </div>
                <hr>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <?php if($_SESSION["memberLevel"] == "admin"){
                        echo '<input class="btn btn-primary" type="submit" name="update_post" value="更新">';
                      }else{
                        echo '<a href="./member_center.php" class="btn btn-warning" role="button">回首頁</a>';
                      } ?> 
                        <!-- echo 'class="hide"';}
                      <input class="btn btn-primary" type="submit" name="update_post" value="更新"> -->
                      <a href="./owner.php" class="btn btn-info" role="button">回列表</a>


                      
                    </div>
                  </div>
                </form>
              </div>

              
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
<!-- load the footer -->
<?php include_once("layouts/backend_footer.php") ?>
</div>

</body>


<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
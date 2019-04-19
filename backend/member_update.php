<?php

session_start();
require_once("../includes/connMysql.php");

function GetSQLValueString($theValue, $theType) {
	switch ($theType) {
	case "string":
	$theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
	break;
	case "int":
	$theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
	break;
	case "email":
	$theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
	break;
	case "url":
	$theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_URL) : "";
	break;
	}
	return $theValue;
}


//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	header("Location: ../index.php");
}
//重新導向頁面
// $redirectUrl="member_center.php";
//執行更新動作
	if(isset($_POST["action"])&&($_POST["action"]=="update")){
	$query_update = "UPDATE memberdata SET m_passwd=?, m_name=?, m_sex=?, m_birthday=?, m_email=?, m_url=?, m_phone=?, m_address=? WHERE m_id=?";
	$stmt = $db_link->prepare($query_update);
	//檢查是否有修改密碼
	$mpass = $_POST["m_passwdo"];
	if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
		$mpass = password_hash($_POST["m_passwd"], PASSWORD_DEFAULT);
	}
	$stmt->bind_param("ssssssssi",
		$mpass,
				GetSQLValueString($_POST["m_name"], 'string'),
				GetSQLValueString($_POST["m_sex"], 'string'),
				GetSQLValueString($_POST["m_birthday"], 'string'),
				GetSQLValueString($_POST["m_email"], 'email'),
				GetSQLValueString($_POST["m_url"], 'url'),
				GetSQLValueString($_POST["m_phone"], 'string'),
				GetSQLValueString($_POST["m_address"], 'string'),
				GetSQLValueString($_POST["m_id"], 'int'));
	$stmt->execute();
	
	// show window alaert for updated
	if($stmt->affected_rows === 0){
		echo "<script language='javascript'>window.alert('資料未執行更新！！'); </script>";
		}else{
		echo "<script language='javascript'>window.alert('已完成更新！！'); </script>";
		}
		$stmt->close();

//若有修改密碼，則登出回到首頁。
if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	$redirectUrl="../index.php";
	}
//重新導向
header("Location: $redirectUrl");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM memberdata WHERE m_username='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);
$row_RecMember = $RecMember->fetch_assoc();
?>


<!-- load the backend_header -->
<?php include_once("layouts/backend_header.php"); ?>
<!-- load the backend_header_menu -->
<?php include_once 'layouts/backend_header_menu.php'; ?>
<!-- load the side menu. contains the logo and sidebar -->
<?php include_once("layouts/backend_side_menu.php"); ?>
<!-- Content Wrapper. Contains page content -->
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
				個人資料表
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> 首頁</a></li>
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
								<?php

								$id = $row_RecMember["m_id"];

								echo "<div align='center'>";
								if ($row_RecMember["avatar"] == 0) {
									echo "<img src='uploads/profile".$id.".jpg' width=200>";
								}else{
									echo "<img src='uploads/profiledefault.jpg'>";
								}
									// echo "<p>".$row_RecMember['m_username']."</p>";
								echo "<hr/>";
								echo "</div>";
									
								echo "<div class='middel_div_right' align='center'>
								<form action='upload_admin.php' method='POST' enctype='multipart/form-data'>
										<label><input type='file' name='file'></label>
										<button type='submit' name='submit'>上傳檔案</button>
										</div>
										</form>"
								 ?>	

								<h3 class="profile-username text-center"><?php echo $owner_name; ?></h3>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>登入帳號</b> <a class="pull-right"><?php echo $row_RecMember["m_username"];?></a>
									</li>
									<li class="list-group-item">
										<b>帳號權限</b> <a class="pull-right"><?php echo ($_SESSION["memberLevel"]); ?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-md-9">
						<div class="box box-primary">
							
							<div class="content">
								
								<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
									
									
									<div><h4 class="heading">密碼更換</h4></div>
									<div class="form-group">
										<label for="InputPassword" class="col-sm-2 control-label">密碼修改</label>
										<div class="col-sm-10">
											<input name="m_passwd" type="password" class="normalinput" id="m_passwd">
											<input name="m_passwdo" type="hidden" id="m_passwdo" value="<?php echo $row_RecMember["m_passwd"]; ?>">
											<small class="form-text text-muted">&nbsp;&nbsp;若不修改密碼，請不要填寫。</small>
										</div>
									</div>
									<div class="form-group">
										<label for="InputPassword1" class="col-sm-2 control-label">再次輸入</label>
										<div class="col-sm-10">
											<input name="m_passwdrecheck" type="password" class="normalinput" id="m_passwdrecheck">
											<small id="emailHelp" class="form-text text-muted">&nbsp;&nbsp;再次輸入修改的密碼，系統將自動登出，請以新密碼登入。</small>
										</div>
									</div><hr size="1" />
									<div><h4 class="heading">個人資料</h4></div>
									<div class="form-group">
										<label for="InputName" class="col-sm-2 control-label">真實姓名</label>
										<div class="col-sm-10">
											<input name="m_name" type="text" class="normalinput" id="m_name" value="<?php echo $row_RecMember["m_name"]; ?>"><small class="form-text text-muted">&nbsp;&nbsp;<font color="#FF0000">*</font></small>
										</div>
									</div>
									<div class="form-group ">
										<label for="InputSex" class="col-sm-2 control-label">性　　別</label>
										<div class="col-sm-3 input-group-prepend">
											<input name="m_sex" type="radio" value="女" <?php if($row_RecMember["m_sex"]=="女") echo "checked";?>>&nbsp;&nbsp;女性&nbsp;&nbsp;
											<input name="m_sex" type="radio" value="男" <?php if($row_RecMember["m_sex"]=="男") echo "checked";?>>&nbsp;&nbsp;男性
										</div>
									</div>
									<div class="form-group">
										<label for="InputBirthday" class="col-sm-2 control-label">生　　日</label>
										<div class="col-sm-10">
											<input name="m_birthday" type="text" class="normalinput" id="m_birthday" value="<?php echo $row_RecMember["m_birthday"];?>"><small id="emailHelp" class="form-text text-muted">&nbsp;&nbsp;西元格式(YYYY-MM-DD)。</small>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="InputEmail col-sm-2 control-label">電子郵件</label>
										<input name="m_email" type="text" class="normalinput" id="m_email" value="<?php echo $row_RecMember["m_email"];?>"><small id="emailHelp" class="form-text text-muted">&nbsp;&nbsp;請確認電子郵件為可使用狀態，以方便未來系統使用。</small>
									</div>
									<div class="form-group">
										<label for="" class="InputTel col-sm-2 control-label">聯絡電話</label>
										<input name="m_phone" type="text" class="normalinput" id="m_phone" value="<?php echo $row_RecMember["m_phone"];?>">
									</div>
									<div class="form-group">
										<label for="" class="InputAddress col-sm-2 control-label">通訊地址</label>
										<input name="m_address" type="text" class="normalinput" id="m_address" value="<?php echo $row_RecMember["m_address"];?>">
									</div>
								</div><hr size="1" />
								<div align="center">
									<input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecMember["m_id"];?>">
									<input name="action" type="hidden" id="action" value="update">
									<button class="btn btn-danger" type="submit" name="Submit2">修改資料</button>
									<button class="btn btn-primary" type="reset" name="Submit3">重設資料</button>
									<button class="btn btn-success" type="button" name="Submit" onClick="window.history.back();">返回上頁</button>
									<!-- <input type="submit" name="Submit2" value="修改資料"> -->
									<!-- <input type="reset" name="Submit3" value="重設資料">
									<input type="button" name="Submit" value="回上一頁" onClick="window.history.back();"> -->
								</div><hr>
							</form>
							
						</div></div></section></div>
						<!-- load the footer -->
						<?php include_once("layouts/backend_footer.php") ?>
					</div>
				</body>
<script language="javascript">
function checkForm(){
if(document.formJoin.m_passwd.value!="" || document.formJoin.m_passwdrecheck.value!=""){
if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
document.formJoin.m_passwd.focus();
return false;
}
}
if(document.formJoin.m_name.value==""){
alert("請填寫姓名!");
document.formJoin.m_name.focus();
return false;
}
if(document.formJoin.m_birthday.value==""){
alert("請填寫生日!");
document.formJoin.m_birthday.focus();
return false;
}
if(document.formJoin.m_email.value==""){
alert("請填寫電子郵件!");
document.formJoin.m_email.focus();
return false;
}
if(!checkmail(document.formJoin.m_email)){
document.formJoin.m_email.focus();
return false;
}
return confirm('確定送出嗎？');
}
function check_passwd(pw1,pw2){
if(pw1==''){
alert("密碼不可以空白!");
return false;
}
for(var idx=0;idx<pw1.length;idx++){
	if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
	alert("密碼不可以含有空白或雙引號 !\n");
	return false;
	}
	if(pw1.length<5 || pw1.length>10){
	alert( "密碼長度只能5到10個字母 !\n" );
	return false;
	}
	if(pw1!= pw2){
	alert("密碼二次輸入不一樣,請重新輸入 !\n");
	return false;
	}
	}
	return true;
	}
	function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
	return true;
	}
	alert("電子郵件格式不正確");
	return false;
	}
	</script>
	
	<!-- jQuery 3 -->
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../dist/js/adminlte.min.js"></script>
	<!-- Sparkline -->
	<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
	<!-- jvectormap  -->
	<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<!-- SlimScroll -->
	<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ChartJS -->
	<script src="../bower_components/chart.js/Chart.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="../dist/js/pages/dashboard2.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../dist/js/demo.js"></script>
	<?php
	$db_link->close();
	?>
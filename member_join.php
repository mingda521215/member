<?php
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
if(isset($_POST["action"])&&($_POST["action"]=="join")){
	require_once("includes/connMysql.php");
	//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT m_username FROM memberdata WHERE m_username='{$_POST["m_username"]}'";
	$RecFindUser=$db_link->query($query_RecFindUser);
	if ($RecFindUser->num_rows>0){
		header("Location: member_join.php?errMsg=1&username={$_POST["m_username"]}");
	}else{
		//若沒有帳號重複即執行新增的動作
		// $query_insert = "INSERT INTO memberdata (m_name, m_username, m_passwd, m_sex, m_birthday, m_email, m_url, m_phone, m_address, m_jointime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
		$query_insert = "INSERT INTO memberdata (m_username, m_passwd, m_email, m_jointime) VALUES (?, ?, ?, NOW())";
		$stmt = $db_link->prepare($query_insert);
		$stmt->bind_param("sss",
			// GetSQLValueString($_POST["m_name"], 'string'),
			GetSQLValueString($_POST["m_username"], 'string'),
			password_hash($_POST["m_passwd"], PASSWORD_DEFAULT),
			// GetSQLValueString($_POST["m_sex"], 'string'),
			// GetSQLValueString($_POST["m_birthday"], 'string'),
			GetSQLValueString($_POST["m_email"], 'email'));
			// GetSQLValueString($_POST["m_url"], 'url'),
			// GetSQLValueString($_POST["m_phone"], 'string'),
			// GetSQLValueString($_POST["m_address"], 'string'));
		$stmt->execute();
		$stmt->close();
		$db_link->close();
		header("Location: member_join.php?loginStats=1");
	}
}
?>
<script language="javascript">
function checkForm(){
	if(document.formJoin.m_username.value==""){
		alert("請填寫帳號!");
		document.formJoin.m_username.focus();
		return false;
	}else{
		uid=document.formJoin.m_username.value;
		if(uid.length<5 || uid.length>12){
			alert( "您的帳號長度只能5至12個字元!" );
			document.formJoin.m_username.focus();
			return false;}
		if(!(uid.charAt(0)>='a' && uid.charAt(0)<='z')){
			alert("您的帳號第一字元只能為小寫字母!" );
			document.formJoin.m_username.focus();
			return false;}
		for(idx=0;idx<uid.length;idx++){
			if(uid.charAt(idx)>='A'&&uid.charAt(idx)<='Z'){
				alert("帳號不可以含有大寫字元!" );
				document.formJoin.m_username.focus();
				return false;}
			if(!(( uid.charAt(idx)>='a'&&uid.charAt(idx)<='z')||(uid.charAt(idx)>='0'&& uid.charAt(idx)<='9')||( uid.charAt(idx)=='_'))){
				alert( "您的帳號只能是數字,英文字母及「_」等符號,其他的符號都不能使用!" );
				document.formJoin.m_username.focus();
				return false;}
			if(uid.charAt(idx)=='_'&&uid.charAt(idx-1)=='_'){
				alert( "「_」符號不可相連 !\n" );
				document.formJoin.m_username.focus();
				return false;}
		}
	}
	if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
		document.formJoin.m_passwd.focus();
			return false;}
	if(document.formJoin.m_name.value==""){
		alert("請填寫姓名!");
		document.formJoin.m_name.focus();
		return false;}
	if(document.formJoin.m_birthday.value==""){
		alert("請填寫生日!");
		document.formJoin.m_birthday.focus();
		return false;}
	if(document.formJoin.m_email.value==""){
		alert("請填寫電子郵件!");
		document.formJoin.m_email.focus();
		return false;}
	if(!checkmail(document.formJoin.m_email)){
		document.formJoin.m_email.focus();
		return false;}
	return confirm('確定送出嗎？');
}
function check_passwd(pw1,pw2){
	if(pw1==''){
		alert("密碼不可以空白!");
		return false;}
	for(var idx=0;idx<pw1.length;idx++){
			if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
				alert("密碼不可以含有空白或雙引號 !\n");
				return false;}
			if(pw1.length<5 || pw1.length>10){
				alert( "密碼長度只能5到10個字母 !\n" );
				return false;}
			if(pw1!= pw2){
				alert("密碼二次輸入不一樣,請重新輸入 !\n");
				return false;}
		}
		return true;
	}
	function checkmail(myEmail) {
		var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(filter.test(myEmail.value)){
			return true;}
		alert("電子郵件格式不正確");
		return false;
	}
	</script>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>WooWeb</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="register_style.css">
<!-- Register Font-->
<link rel="stylesheet" type="text/css" href="includes/reg/css/nunito-font.css">
<!-- Register Main Style Css -->
<link rel="stylesheet" href="/includes/reg/css/style.css"/>


<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('會員新增成功\n請用申請的帳號密碼登入。');
		window.location.href='index.php';
</script>
<?php }?>

<body class="form-v9">
	<div class="page-content">
		<div class="form-v9-content" style="background-image: url('includes/reg/images/form-v9.jpg')">
			<form class="form-detail" action="" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
				<h2>使用者註冊</h2>

				<?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
					<div class="errDiv">帳號 <?php echo $_GET["username"];?> 已經有人使用！</div>
					<?php }?>

				<div class="form-row-total">
					<div class="form-row">
						<input type="text" name="m_username" id="m_username" class="input-text" placeholder="使用帳號" required>
					</div>
					<div class="form-row">
						<input type="text" name="m_email" id="m_email" class="input-text" placeholder="電子郵件" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					</div>
				</div>
				<div class="form-row-total">
					<div class="form-row">
						<input type="password" name="m_passwd" id="m_passwd" class="input-text" placeholder="使用密碼" required>
					</div>
					<div class="form-row">
						<input type="password" name="m_passwdrecheck" id="m_passwdrecheck" class="input-text" placeholder="確認密碼" required>
					</div>
				</div>
				<div class="form-row-last">
					<input name="action" type="hidden" id="action" value="join">
					<input type="submit" name="Submit2" value="送出申請"><br><br>
					<input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
				</div>
			</form>
		</div>
	</div>
</body>

								
</html>
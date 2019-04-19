<?php

session_start();
require_once("../includes/connMysql.php");

//繫結登入會員資料
function selectMember(){
	
	global $db_link;

	$query_RecMember = "SELECT * FROM memberdata WHERE m_username='{$_SESSION["loginMember"]}'";
	$RecMember = $db_link->query($query_RecMember);
	$row_RecMember = $RecMember->fetch_assoc();

}

?>
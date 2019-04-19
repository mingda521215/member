<?php
require_once("../includes/connMysql.php");
session_start();

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
<?php include_once('layouts/backend_side_menu.php'); ?>

<?php

if(isset($_GET['source'])){

$source = $_GET['source'];

} else {

$source = '';

}

switch($source) {
    
    case 'add_post';
    
     include "includes/add_post.php";
    
    break;    
    
    case 'edit_owner';
    
    include "includes/edit_owner.php";
    break;
    
    default:
    
    include "owner.php";
    
    break;
    
}

?>

  <!-- load the footer -->
<?php include_once("layouts/backend_footer.php") ?>

</div>
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
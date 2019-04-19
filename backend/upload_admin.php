<?php
session_start();
require_once("../includes/connMysql.php");

$query_RecMember = "SELECT * FROM memberdata WHERE m_username='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);
$row_RecMember = $RecMember->fetch_assoc();
$id = $row_RecMember["m_id"];

if (isset($_POST['submit'])) {
	$file = $_FILES['file'];

	$fileName    = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize    = $file['size'];
	$fileError   = $file['error'];
	$fileType    = $file['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'png', 'pdf');

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileZide < 1000000) {
				$fileNameNew = "profile".$id.".".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql = "UPDATE memberdata SET avatar = 0 WHERE m_id='$id';";
				$result = mysqli_query($db_link, $sql);
				header("Location: member_update.php?uploadsuccess");
			}else{
				echo "Your file is too big!";
			}
		}else{
			echo "There was an error uploading your file!";
		}
	}else{
		echo "You cannot upload files of this type!";	
	}
}
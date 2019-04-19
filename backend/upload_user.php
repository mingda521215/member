<?php
session_start();
require_once("../includes/connMysql.php");

$query_RecUser = "SELECT * FROM users WHERE fee_code = $fee_code";
$RecUser = $db_link->query($query_RecUser);
$row_RecUser = $RecUser->fetch_assoc();
$id = $row_RecUser["fee_code"];

if (isset($_POST['submit'])) {
	$file = $_FILES['file'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'png', 'pdf');

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileZide < 1000000) {
				$fileNameNew = "user".$id.".".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql = "UPDATE users SET avatar = 0 WHERE fee_code='$id';";
				$result = mysqli_query($db_link, $sql);
				header("Location: owner.php?uploadsuccess");
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
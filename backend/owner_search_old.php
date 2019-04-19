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

  
  // header("Cache-Control: no-cache, must-revalidate");
  
  // if( empty($_SESSION['login']) ) header( "Location: ./login.php" );
  
  
if( empty($_SESSION['login']) ) header( "Location: ./login.php" );
  
  
  if( !empty($_POST["searchtype"]) ) {
    
    
    switch( $_POST["searchtype"] ) {
    case "s_bike1":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `bike1` = '%$_POST[search]%' || `bike2` = '%$_POST[search]%' || `bike3` = '%$_POST[search]%' || `bike4` = '%$_POST[search]%';");
      break;
    case "fee_code":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `fee_code` LIKE '%$_POST[search]%';");
      break;
    case "name":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `owner_name` LIKE '%$_POST[search]%' OR `lessee_name` LIKE '%$_POST[search]%';");
      break;
    case "phone":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `owner_phone` LIKE '%$_POST[search]%' OR `lessee_phone` LIKE '%$_POST[search]%';");
      break;
    case "sid":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `owner_id` LIKE '%$_POST[search]%' OR `lessee_id` LIKE '%$_POST[search]%';");
      break;
    case "address":
      $result = mysqli_query($db_link, "SELECT * FROM `fee2` WHERE `address` LIKE '%$_POST[search]%';");
      break;
    default:
      ERROR("search type failed!");
    }

  }

?>



<script type="text/javascript">
function choose( i )
{
  //alert(i);
  document.getElementById("input_houseid").setAttribute("value", i);
  document.getElementById("results").submit();
}
</script>

<style type="text/css">
body {
  background-color: #FFC;
}
</style>
</head>
<body>

<table align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="sc1.png" width="875" height="68" /></td>
  </tr>
  <tr>
    <td align="center">
    <form id="search" action="owner_search.php" method="post">
      <select name="searchtype">
        <option value="s_bike1">車位號碼</option>
        <!-- <option value="fee_code">管理費序號</option>
        <option value="name">名稱</option>
        <option value="phone">電話</option>
        <option value="sid">身分證字號</option>
        <option value="address">住址</option> -->
      </select>
      <input name="search" type="input" />
      <input name="submit" type="submit" value="       查詢     " />
    </form>
  </td>
  </tr>
  <br>
  <tr>
    <td><p><img src="sc2.png" width="876" height="71" /></p></td>
  </tr>
  <tr>
    <td>
    <form id="results" action="includes/edit_owner.php" method="post">
      <input name="searchtype" type="hidden" value="<?php echo $_POST['searchtype'] ?>"/>
      <input name="search" type="hidden" value="<?php echo $_POST['search'] ?>"/>
      <input id="input_houseid" name="houseid" type="hidden" />

      <table border="1">
      <tr>
        <th width="80" >車位號碼</th>
        <th width="89" >管理費代號</th>
        <!-- <th width="80" >屋主名稱</th>
        <th width="100" >屋主電話</th>
        <th width="110" >承租人名稱</th>
        <th width="102" >承租人電話</th>
        <th width="220" >地址</th> -->
        <th width="40" >選擇</th>
      </tr>

<?php 
    if( isset($_POST["searchtype"]) ) {
      if( $row = mysqli_fetch_array($result) ) {?>
      <tr>
        <?php 

        echo "<tr>";
        echo "<td>" . $_POST['search'] . "</td>";
        echo "<td>" . $row['fee_code'] . "</td>";
        echo "<td>" . $row['owner_name'] . "</td>";
        // echo "<td>" . $row['owner_phone'] . "</td>";
        // echo "<td>" . $row['lessee_name'] . "</td>";
        // echo "<td>" . $row['lessee_phone'] . "</td>";
        // echo "<td>" . $row['address'] . "</td>";
        // echo "</tr>";

         ?>
        <!-- <td align="center"><?php echo $row["house_num"] ?></td>
        <td align="center"><?php echo $row["fee_code"] ?></td>
        <td align="center"><?php echo $row["owner_name"] ?></td>
        <td align="center"><?php echo $row["owner_phone"] ?></td>
        <td align="center"><?php echo $row["lessee_name"] ?></td>
        <td align="center"><?php echo $row["lessee_phone"] ?></td>
        <td><?php echo $row["address"] ?></td>
        <td><button type="button" onclick="choose( '<?php echo $row["house_num"] ?>' )" >選擇</button> </td> -->
      </tr>
  <?php }
  }     ?>
      </table>
    </form>
  </td>
  </tr>
</table>
<p>&nbsp;</p>

</body>

  <!-- load the footer -->
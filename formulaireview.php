<?php include 'header.php';

$uniqueid=mysql_real_escape_string(trim($_GET['form']));


echo 'formulaire view '.$uniqueid;






include 'footer.php';?>
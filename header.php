<?php
session_start();
//--interdire IE
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') == true || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true){header( 'Location: ie.php' ) ;exit(); }

//--verifie id de session
if ($_SESSION['sessionid']!='kjFK_69kA5+k47gv-DG&ik'){
	session_start();
	session_unset();
	session_destroy();
	header('Location: login.php'); exit();
}

$titre_site="FormCreator";
include 'functions.php';
?>

<html>
<head>
<meta charset="UTF-8">
<title><?php echo $titre_site;?></title>
 
<link rel="stylesheet" type="text/css" href="normalize.css">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="mobile.css">
<link rel="icon" href="favicon.ico">
<link rel="icon" type="image/png" href="favicon.png"> 
</head>
<body>
<div id="titre">
<img class="logo" src="img/logo_formcreator2.svg" /><h1><?php echo $titre_site;?></h1>

<div class="infos_header">
<?php
	echo '<a class="header_info" href="disconnect.php" title="Se déconnecter">'.ucfirst($_SESSION['prenom']).' '.mb_strtoupper($_SESSION['nom']).'</a>';
?>

</div>


</div>

<div id="main">
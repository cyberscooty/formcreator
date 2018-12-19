<?php
session_start();

if ($_SESSION['sessionid']!='kjFK_69kA5+k47gv-DG&ik'){
	session_start();
	session_unset();
	session_destroy();
	header('Location: login.php'); exit();
}


$titre_site="FormCreator";
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
<a href="index.php" title="Retour page principale"> <img class="logo" src="img/logo_formcreator2.svg" /><h1><?php echo $titre_site;?></h1></a>

<div class="infos_header">
<?php

	echo '<a class="header_info" href="disconnect.php" title="Se déconnecter">'.ucfirst($_SESSION['prenom']).' '.mb_strtoupper($_SESSION['nom']).'</a>';

?>

</div>


</div>

<div id="main">
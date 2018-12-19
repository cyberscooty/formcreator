<?php
session_start();

//--interdire IE
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') == true || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true){header( 'Location: ie.php' ) ;exit(); }



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
 <a href="index.php" title="Retour page principale"><img class="logo" src="img/logo_formcreator2.svg" /><h1><?php echo $titre_site;?></h1></a>
</div>

<div id="main">
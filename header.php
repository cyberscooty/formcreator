<?php
session_start();
//--interdire IE
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') == true || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') == true){header( 'Location: ie.php' ) ;exit(); }

//--verifie id de session sauf si invité pour remplir questionnaire
if ($_SESSION['sessionid']!='kjFK_69kA5+k47gv-DG&ik' && strpos($_SERVER['REQUEST_URI'],'formulaireview.php')==FALSE && strpos($_SERVER['REQUEST_URI'],'formviewsave.php')==FALSE){
	session_start();
	session_unset();
	session_destroy();
	header('Location: login.php'); exit();
}

$titre_site="FormCreator";
include 'functions.php';


/*
#c2d81d; vert clair (defaut)
#75c7f9; bleu clair
#f3f900; jaune
#ff6060; sorte de rouge
#b493ff; violet
#ff93f6; rose
#ff93a1; old rose
#acacac; gris foncé
#f1f1f1; gris clair
#f9ad75; orange*/
$colors=array('c2d81d','75c7f9','f3f900','ff6060','b493ff','ff93f6','ff93a1','acacac','f1f1f1','f9ad75');







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





<STYLE>
:root {--main-color: #c2d81d; /*vert clair (defaut)*/}
</STYLE>

</head>
<body>
<div id="titre">
<img class="logo" src="img/logo_formcreator2.svg" /><h1><?php echo $titre_site;?></h1>

<div class="infos_header">

<input type="checkbox" id="header_info"><label for="header_info"><?php echo ucfirst($_SESSION['prenom']).' '.mb_strtoupper($_SESSION['nom']);?></label>
<div class="info_entry_box">
<a href="profil.php" class="info_entry">Mon profil</a>
<a href="disconnect.php" class="info_entry">Se déconnecter</a>
</div>

<?php
	//echo '<a class="header_info" href="disconnect.php" title="Se déconnecter">'.ucfirst($_SESSION['prenom']).' '.mb_strtoupper($_SESSION['nom']).'</a>';
?>









</div>


</div>

<div id="main">
<?php include 'header.php';

//type questions
//1		réponses courte
//2		Paragraphe
//3		choix multiple (radio)
//4		cases à cocher (checkbox)
//5		Liste déroulante
//6		echélle linéaire
//7		Grille à choix multiple (radio)
//8		grille de cases à cocher (checkbox)
//9		date
//10	heure
	




//--récupère uniqueid si existe
$uniqueid=mysql_real_escape_string(trim($_GET['form']));

//--check uniqueid n'est pas vide
if ($uniqueid=='') {header('Location: index.php'); exit();}

//--création nouveau formulaire
if ($uniqueid=='new'){
	$uniqueid=(date('z')*2).date('y').str_replace('.','',uniqid('f',TRUE));
	$titre='Formulaire sans titre';
	$now = date("Y-m-d H:i:s");
	$userid=$_SESSION['userid'];
	include 'connect.php';
	$result = $db->exec("INSERT INTO formulaires(uniqueid, titre,owner,datecreated,actif) VALUES('$uniqueid', '$titre','$userid','$now',1)");
}

//--check si uniqueid existe
include 'connect.php';
$result = $db->query("SELECT * FROM formulaires WHERE uniqueid='$uniqueid'");
$row_count = $result->rowCount();
if ($row_count==0){header('Location: index.php'); exit();}


//--recup valeurs table
while($row = $result->fetch(PDO::FETCH_ASSOC)) {$form_id=$row['id'];$titre=$row['titre'];$description=$row['description'];$couleur=$row['couleur'];$background=$row['background'];
												$reponses_possibles=$row['reponses_possibles'];$datecreated=$row['datecreated'];$datemodif=$row['datemodif'];}


echo '<form action="formulaire.php" method="post">';
echo '<div class="question_box">';
echo '<input type="text" name="form_titre" class="form_titre" value="'.$titre.'" placeholder="Titre du formulaire" required>';
echo '<textarea name="form_description" class="form_description" placeholder="Description du formulaire">'.$description.'</textarea>';
echo '</div>';







$result = $db->query("SELECT * FROM questions WHERE form_id='$form_id'");
$row_count = $result->rowCount();
if ($row_count==0){//echo '<div class="question_box" style="text-align:center;">-Ce formulaire ne contient pas encore de question-</div>';
	$now = date("Y-m-d H:i:s");
	$result = $db->exec("INSERT INTO questions(form_id, datecreated,type) VALUES($form_id, '$now',1)");
	$insertId = $db->lastInsertId();}
	
	
	//questions déjà enregistrés
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {echo '<div class="question_box">'.$row['titre'].' '.$row['type'].'';$question_id=$row['id'];
		$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id'");
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo $row2['valeur'].'<br>'; }
	
	echo '</div>';
	}
	


//--boutons ajout question ou titre
echo '<div class="question_box align_center">';
echo '<div class="add_new_question">Ajouter une question</div><div class="add_new_question">Ajouter un titre</div>';
echo '</div>';







echo '</form>';











include 'footer.php';?>
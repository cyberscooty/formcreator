<?php
include 'header.php';


$uniqueid=mysql_real_escape_string(trim($_GET['form']));
	include 'connect.php';
	$result = $db->query("SELECT * FROM formulaires WHERE uniqueid='$uniqueid'");
	$row_count = $result->rowCount();
	if ($row_count==0){header('Location: index.php'); exit();}
	//--recup valeurs table
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$form_id=$row['id'];$form_titre=$row['titre'];$form_description=$row['description'];$couleur=$row['couleur'];$background=$row['background'];
												$reponses_possibles=$row['reponses_possibles'];$datecreated=$row['datecreated'];$datemodif=$row['datemodif'];$wallaper=$row['background'];}
												
												
//couleur formulaire et wallpaper
if ($wallaper==''){$wallaper='nature1.jpg';}
echo '<style>:root {--main-color:#'.$colors[$couleur].'}#wallpaper {background: url(wallpapers/'.$wallaper.');background-size: cover;}</style>';



	//--titre formulaire
echo '<div class="question_box">';
echo '<div class="mode_modif">Réponses</div>';
echo '<div class="form_titre">'.$form_titre.'</div>';
echo '<div class="form_description">'.nl2br($form_description).'</div>';
echo '</div>';

	$result = $db->query("SELECT * FROM questions WHERE form_id=$form_id ORDER BY position ASC");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$qid=$row['id'];$question_type=$row['type'];$is_required=$row['is_required'];
		
		//--titre seul
	if ($question_type==0){ //titre seul
			echo '<div class="titre_seul_box"><div class="titre_seul">'.$row['titre'].'</div></div>';}
		
		//--questions
	if ($question_type!=0){	
	echo '<div class="question_box">';
	//titre
	echo '<div class="quest_titre">'.$row['titre'];
	if ($is_required==1){echo '<div class="is_required" title="Ce champ est obligatoire">*</div>';}
	echo '</div>';
	
	include 'results_datas.php';
	
	echo '</div>';}
		
		
		
		






		}



















include 'footer.php';?>
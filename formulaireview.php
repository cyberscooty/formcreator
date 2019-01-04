<?php include 'header.php';

$uniqueid=mysql_real_escape_string(trim($_GET['form']));
	include 'connect.php';
	$result = $db->query("SELECT * FROM formulaires WHERE uniqueid='$uniqueid'");
	$row_count = $result->rowCount();
	if ($row_count==0){header('Location: index.php'); exit();}
	//--recup valeurs table
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$form_id=$row['id'];$form_titre=$row['titre'];$form_description=$row['description'];$couleur=$row['couleur'];$background=$row['background'];
												$reponses_possibles=$row['reponses_possibles'];$datecreated=$row['datecreated'];$datemodif=$row['datemodif'];}






echo '<form action="formviewsave.php" class="one_formulaire" method="post">';
echo '<input type="hidden" name="uniqueid" value="'.$uniqueid.'">';
echo '<input type="hidden" name="form_id" value="'.$form_id.'">';
echo '<input class="fake_submit" type="submit" name="ok" value="Enregistrer les modifications">';
//--bouton retour en haut à gauche
echo '<input type="submit" class="bt_hautgauche" name="back" value="" title="Retour page principale">';



//--titre formulaire
echo '<div class="question_box">';
echo '<div class="form_titre">'.$form_titre.'</div>';
echo '<div class="form_description">'.nl2br($form_description).'</div>';
echo '</div>';

//--questions
$result = $db->query("SELECT * FROM questions WHERE form_id='$form_id' ORDER BY position ASC");
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
	$qid=$row['id'];$question_type=$row['type'];$is_required=$row['is_required'];
	
//--titre seul
	if ($question_type==0){ //titre seul
			echo '<div class="titre_seul_box"><div class="titre_seul">'.$row['titre'].'</div></div>';}	
	

	
if ($question_type!=0){	
	echo '<div class="question_box">';
	//--titre
	echo '<div class="quest_titre">'.$row['titre'];
	if ($is_required==1){echo '<div class="is_required" title="Champ requis">*</div>';}
	echo '</div>';
	
	include 'form_view_datas.php';
	
	echo '</div>';}
}

echo '<input type="submit" class="bouton bt_valid" name="validform" value="Valider">';

echo '</form>';


include 'footer.php';?>
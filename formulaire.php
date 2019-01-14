<?php include 'header.php';

include 'form_cas.php';

//type questions
//1		réponses courte
//2		Paragraphe
//3		choix multiple (radio)
//4		cases à cocher (checkbox)
//5		Liste déroulante
//6		échelle linéaire
//7		Grille à choix multiple (radio)
//8		grille de cases à cocher (checkbox)
//9		date
//10	heure
	

echo '<form action="formulaire.php" class="one_formulaire" method="post">';
echo '<input type="hidden" name="uniqueid" value="'.$uniqueid.'">';
echo '<input class="fake_submit" type="submit" name="ok" value="Enregistrer les modifications">';
//--bouton retour en haut à gauche
echo '<input type="submit" class="bt_hautgauche" name="back" value="" title="Retour page principale">';
//--bouton envoyer en haut à droite
echo '<input type="submit" class="bt_envoyer" name="envoyer" value="Envoyer" title="">';





//--boutons à droite (ajout question ou titre)
echo '<div class="box_droite"><input type="submit" name="add_question" class="bt_droite bt_add_question" value="" title="Ajouter une question">
	<input type="submit" name="add_titre" class="bt_droite bt_titre" value="" title="Ajouter un titre">
	<input type="submit" class="bt_droite bt_paint" name="paint" value="" title="Personnaliser">
	<input type="submit" class="bt_droite bt_save" name="ok" value="" title="Valider les modifications">
	<input type="submit" class="bt_droite bt_view" name="view" value="" title="Aperçu du formulaire">
	<input type="submit" class="bt_droite bt_results" name="results" value="" title="Voir les résultats">
	<input type="submit" class="bt_droite bt_back" name="back" value="" title="Retour page principale">
	</div>';


	
	
//--titre formulaire
echo '<div class="question_box">';
echo '<div class="mode_modif">Mode création</div>';
echo '<input type="text" name="form_titre" class="form_titre" value="'.$form_titre.'" placeholder="Titre du formulaire" required>';
echo '<textarea name="form_description" class="form_description" placeholder="Description du formulaire">'.stripcslashes($form_description).'</textarea>';
echo '</div>';


//--questions

$result = $db->query("SELECT * FROM questions WHERE form_id='$form_id' AND type!=0");
$row_count = $result->rowCount();
if ($row_count==0){ //création d'une question si vide
	$now = date("Y-m-d H:i:s");
	$result = $db->exec("INSERT INTO questions(form_id, titre,datecreated,type,position) VALUES($form_id,'Question sans titre', '$now',3,2)");
	$insertId = $db->lastInsertId();}
	
	
	//affiche questions déjà enregistrés
	$result = $db->query("SELECT * FROM questions WHERE form_id='$form_id' ORDER BY position");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$qid=$row['id'];$question_type=$row['type'];$position=$row['position'];
		
		if ($question_type==0){ //titre seul
			echo '<div class="titre_seul_box">';
			echo '<input type="text" name="quest_titre'.$qid.'" class="titre_seul" value="'.$row['titre'].'" placeholder="Titre de la question">';
			echo '<div class="box_droite_titre">';
			if ($position<$posmax){echo '<input type="submit" name="descendre'.$qid.'" value="descendre" title="Descendre" class="question_options question_options1">';}
			if ($position>2){echo '<input type="submit" value="monter" title="Monter" name="monter'.$qid.'" class="question_options question_options2">';}
			echo '<input type="submit" value="suppr_question" name="suppr_question'.$qid.'" title="Supprimer cette question" class="question_options question_options3"></div>';
			echo '</div>';
		}
		
		if ($question_type!=0){
			echo '<div class="question_box">';
	//type de question	
		
		echo '<input type="text" name="quest_titre'.$qid.'" class="quest_titre" value="'.$row['titre'].'" placeholder="Titre de la question">';
		
		echo '<div class="question_type"><select name="type'.$qid.'">';
			if ($question_type==1){$checked=' selected';} else{$checked='';}
			echo '	<option value="1" '.$checked.'>Réponse courte</option>';
			if ($question_type==2){$checked=' selected';} else{$checked='';}
			echo '	<option value="2" '.$checked.'>Réponse longue</option>';
			if ($question_type==3){$checked=' selected';} else{$checked='';}
			echo '	<option value="3" '.$checked.'>Choix multiple (radio)</option>';
			if ($question_type==4){$checked=' selected';} else{$checked='';}
			echo '	<option value="4" '.$checked.'>Cases à cocher (checkbox)</option>';
			if ($question_type==5){$checked=' selected';} else{$checked='';}
			echo '	<option value="5" '.$checked.'>Liste déroulante</option>';
			if ($question_type==6){$checked=' selected';} else{$checked='';}
			echo '	<option value="6" '.$checked.'>Échelle linéaire</option>';
			if ($question_type==9){$checked=' selected';} else{$checked='';}
			echo '	<option value="9" '.$checked.'>Date</option>';
			if ($question_type==10){$checked=' selected';} else{$checked='';}
			echo '	<option value="10" '.$checked.'>Heure</option></select>';
			
			if ($position<$posmax){echo '<input type="submit" name="descendre'.$qid.'" value="descendre" title="Descendre" class="question_options question_options1">';}
			if ($position>2){echo '<input type="submit" value="monter" title="Monter" name="monter'.$qid.'" class="question_options question_options2">';}
			echo '<input type="submit" value="suppr_question" name="suppr_question'.$qid.'" title="Supprimer cette question" class="question_options question_options3">';
			
			echo '</div>';
				
		include 'form_datas.php';		
		//Ce champ est obligatoire?
	if ($row['is_required']==1){$is_required=' checked';} else {$is_required='';}
	echo '<div class="required_box">
			
			<input type="checkbox" id="required'.$qid.'" name="required'.$qid.'" class="required_checkbox" value="1" '.$is_required.'>
			<label class="required_label" for="required'.$qid.'"><div class="required_text">Obligatoire</div></label>
			</div>';
	echo '</div>';}
	}
	








echo '<div id="bottom"></div>';
echo '</form>';











include 'footer.php';?>
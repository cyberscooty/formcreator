<?php

echo '<div class="question_values">';

	if ($question_type==1 || $question_type==2) //réponse courte
	{
	$result2 = $db->query("SELECT * FROM reponses WHERE question_id='$qid'");
	$row_count2 = $result2->rowCount();
	if ($row_count2>1){$s='s';}else{$s='';}
	echo '<div class="nb_result">Nombre de résultat'.$s.' : '.$row_count2.'</div>';
	echo '<ul>';
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
		echo '<li>'.$row2['valeur'].'</li>';
		}
	echo '<ul>';
	}

	
	if ($question_type==3 || $question_type==4 || $question_type==5) //choix multiple (radio)
	{
	$result2 = $db->query("SELECT COUNT(*) AS nb_reponses, data.valeur AS dvaleur FROM reponses,data WHERE reponses.valeur=data.id AND reponses.question_id='$qid' GROUP BY reponses.valeur ORDER BY nb_reponses DESC");
	$result3 = $db->query("SELECT COUNT(*) AS nb_reponses FROM `reponses` WHERE question_id=47 GROUP BY valeur ORDER BY nb_reponses DESC LIMIT 1");
	while($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {$nbmax=$row3['nb_reponses'];}
	

		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$nbrep=$row2['nb_reponses'];
			$titre_val=$row2['dvaleur'];
		echo '<div class="rep_titre">'.$titre_val.'</div>';
		echo '<meter class="result_bar" value="'.$nbrep.'" min="0" max="'.$nbmax.'"></meter>';
		echo '<div class="nb_rep">'.$nbrep.'</div>';
		
		}
	}
		
	
		
	if ($question_type==6) //échelle linéaire
	{
		
	}
	
	
	if ($question_type==7) //Grille à choix multiple (radio)
	{
		
	}
	
	
	if ($question_type==8) //grille de cases à cocher (checkbox)
	{
		
	}
	
	
	if ($question_type==9) //Date
	{
		
	}
	
	
	if ($question_type==10) //Heure
	{
		
	}



echo '</div>';



?>
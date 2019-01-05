<?php

echo '<div class="question_values">';

	if ($question_type==1 || $question_type==2) //réponse courte
	{
	$result2 = $db->query("SELECT * FROM reponses,users WHERE ((user_id=users.id AND question_id='$qid') OR (user_id='0' AND question_id='$qid'))  AND valeur!=''");
	$row_count2 = $result2->rowCount();
	if ($row_count2>1){$s='s';}else{$s='';}
	echo '<div class="nb_result">Nombre de résultat'.$s.' : '.$row_count2.'</div>';
	
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
		if ($row2['user_id']!='0'){$name=ucfirst($row2['prenom']).' '.mb_strtoupper($row2['nom']);} else {$name='Anonyme';}
		if ($row2['valeur']!=''){echo '<div class="result_user">'.$name.' dit:</div>
		<div class="result_text">'.nl2br($row2['valeur']).'</div>
		';}
		}
	
	}

	
	if ($question_type==3 || $question_type==4 || $question_type==5) //radio OU checkbox OU liste déroulante
	{
	$result2 = $db->query("SELECT COUNT(*) AS nb_reponses, data.valeur AS dvaleur FROM reponses,data WHERE reponses.valeur=data.id AND reponses.question_id='$qid' GROUP BY reponses.valeur ORDER BY nb_reponses DESC");
	$result3 = $db->query("SELECT COUNT(*) AS nb_reponses FROM `reponses` WHERE question_id='$qid' GROUP BY valeur ORDER BY nb_reponses DESC LIMIT 1");
	while($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {$nbmax=$row3['nb_reponses'];}
	
		$i=1;$nbvotant=0;
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$nbrep=$row2['nb_reponses'];
			$titre_val=$row2['dvaleur'];
		echo '<div class="rep_titre">'.$titre_val.'</div>';
		//echo '<meter class="result_bar" value="'.$nbrep.'" min="0" max="'.$nbmax.'"></meter>';
		
		$pourcent=$nbrep*100/$nbmax;
		echo '<style>@keyframes anim_jauge'.$i.' {0% {width:0;}100% {width:'.$pourcent.'%;}}</style>';
		echo '<div class="fond_jauge"><div class="jauge" style="animation: anim_jauge'.$i.' 2s forwards;"></div></div>';
		
		if ($nbrep>1){$s='s';} else {$s='';}
		echo '<div class="nb_rep">'.$nbrep.' personne'.$s.'</div>';
		
		
		$i++;$nbvotant=$nbvotant+$nbrep;
		}
		if ($nbvotant>1){$s='s';}else{$s='';}
		echo '<div class="nb_result">Nombre de votant'.$s.' : '.$nbvotant.'</div>';
	}
		
	if ($question_type==6 || $question_type==9 || $question_type==10) //échelle linéaire ou date ou heure
	{
		$result2 = $db->query("SELECT COUNT(*) AS nb_reponses,valeur AS dvaleur FROM reponses WHERE reponses.question_id='$qid' GROUP BY reponses.valeur ORDER BY nb_reponses DESC");
		$result3 = $db->query("SELECT COUNT(*) AS nb_reponses FROM `reponses` WHERE question_id='$qid' GROUP BY valeur ORDER BY nb_reponses DESC LIMIT 1");
		while($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {$nbmax=$row3['nb_reponses'];}
		
		
		$t=1;$nbvotant=0;
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
			$nbrep=$row2['nb_reponses'];
			$titre_val=$row2['dvaleur'];
		
		if ($question_type==9 && $titre_val!=''){$titre_val=datefr($titre_val);}
		if ($question_type==10 && $titre_val!=''){$titre_val=heurefr($titre_val);}
		if ($titre_val==''){$titre_val='N\'a pas répondu';}
		
			
		echo '<div class="rep_titre">'.$titre_val.'</div>';
				
		$pourcent=$nbrep*100/$nbmax;
		echo '<style>@keyframes anim_jauge'.$t.' {0% {width:0;}100% {width:'.$pourcent.'%;}}</style>';
		echo '<div class="fond_jauge"><div class="jauge" style="animation: anim_jauge'.$t.' 2s forwards;"></div></div>';
		
		if ($nbrep>1){$s='s';} else {$s='';}
		echo '<div class="nb_rep">'.$nbrep.' personne'.$s.'</div>';
		$t++;$nbvotant=$nbvotant+$nbrep;
		}
		if ($nbvotant>1){$s='s';}else{$s='';}
		echo '<div class="nb_result">Nombre de votant'.$s.' : '.$nbvotant.'</div>';
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
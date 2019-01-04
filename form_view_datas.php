<?php


echo '<div class="question_values">';

if($is_required==1){$required=' required';} else {$required='';}


	

	if ($question_type==1) //réponse courte
		{
		
		echo '<input name="champ'.$qid.'" class="values_default type4" type="text" value="" '.$required.'>';	
		}

	if ($question_type==2) //paragraphe
		{
		
		echo '<textarea class="values_default type5" name="champ'.$qid.'" '.$required.'></textarea>'; 	
		}

	if ($question_type==3) //choix multiple (radio)
		{
		$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
			while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
				
				echo '<div class="elmt_box">
				<input class="inputradio" type="radio" name="champ'.$qid.'" id="radio'.$row2['id'].'" value="'.$row2['id'].'" '.$required.'>
				<div class="nice_radio"></div>
				<label for="radio'.$row2['id'].'">'.$row2['valeur'].'</label>
					</div>';				
			}		
		}
	
	if ($question_type==4) //cases à cocher (checkbox) view_checkbox values_default 
		{
		$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
			while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
				echo '<div class="elmt_box">
				<input class="inputcheckbox" type="checkbox" name="checkbox'.$row2['id'].'" id="checkbox'.$row2['id'].'" value="1">
				<div class="nice_checkbox"></div>
				<label for="checkbox'.$row2['id'].'">'.$row2['valeur'].'</label>
					</div>';				
			}			
		}
	
	if ($question_type==5) //Liste déroulante	
		{
		$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
			echo '<select class="view_select values_default" name="champ'.$qid.'" '.$required.'>';
			while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
				echo '<option value="'.$row2['id'].'">'.$row2['valeur'].'</option>';
			}				
			echo '</select>';
			
		}
		
	if ($question_type==6) //échelle linéaire
		{
			$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=1 ORDER BY valeur ASC LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$min=(int)$row2['valeur'];}
				
			$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=1 ORDER BY valeur DESC LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$max=(int)$row2['valeur'];}
						
			echo '<div>';
			for ($i = $min; $i <= $max; $i++) {echo '<div class="ligne1"><label for="radio'.$i.'">'.$i.'</label></div>';}
			echo '</div>';
			for ($i = $min; $i <= $max; $i++) {echo '<div class="ligne2"><input class="view_echelle" type="radio" name="champ'.$qid.'" id="radio'.$i.'" value="'.$i.'" '.$required.'><div class="nice_echelle"></div></div>';}
			
		}
		
	if ($question_type==7) //Grille à choix multiple (radio)
		{}
	
	if ($question_type==8) //grille de cases à cocher (checkbox)
		{}
	
	if ($question_type==9) //Date
		{
		echo '<input type="date" class="values_default" name="champ'.$qid.'" value="" '.$required.'>';
			
		}
		
	if ($question_type==10) //Heure
		{
		echo '<input type="time" class="values_default" name="champ'.$qid.'" value="" '.$required.'>';	
		}



echo '</div>';




?>
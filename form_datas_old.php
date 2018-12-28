<?php
	
		echo '<div class="question_values">';
		
		if ($question_type==1) //réponse courte
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<input type="text" value="'.$row2['valeur'].'">'; }
			}
		
	
		if ($question_type==2) //paragraphe
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<textarea>'.$row2['valeur'].'</textarea>'; }
			}
	
		if ($question_type==3) //choix multiple (radio)
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<input type="radio" name="radio'.$question_id.'" id="radio'.$row2['id'].'" value="1">
																		<label for="radio'.$row2['id'].'">'.$row2['valeur'].'</label>'; }
			}
	
		if ($question_type==4) //cases à cocher (checkbox)
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<input type="checkbox" name="checkbox'.$question_id.'" id="checkbox'.$row2['id'].'" value="1">
																		<label for="checkbox'.$row2['id'].'">'.$row2['valeur'].'</label>'; }
			}
		
		if ($question_type==5) //Liste déroulante
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0");
				echo '<select>';
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<option value="'.$row2['id'].'">'.$row2['valeur'].'</option>'; }
				echo '</select>';
			}
		
		if ($question_type==6) //échelle linéaire
			{
				echo 'Echelle de valeur de <input type="number" value="0" MIN=-100 MAX=100> à <input type="number" value="5" MIN=-100 MAX=100>';
			}

		if ($question_type==7) //Grille à choix multiple (radio)
			{
				echo '--pas encore implémenté--';
			}
			
		if ($question_type==8) //grille de cases à cocher (checkbox)
			{
				echo '--pas encore implémenté--';
			}
			
		if ($question_type==9) //Date
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<input type="date" value="'.$row2['valeur'].'">'; }
			}
			
		if ($question_type==10) //Heure
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$question_id' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<input type="time" value="'.$row2['valeur'].'">'; }
			}
		
		
		
			
		echo '</div>';
		
		
		
?>
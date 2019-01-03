<?php
	
	//echo '<style>#elmt'.$id.':hover .supprval{display:block;}</style>';
	
		echo '<div class="question_values">';
		
		if ($question_type==1) //réponse courte
			{
				$champ='';
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$champ=$row2['valeur']; }
				echo '<input name="champ'.$row2['id'].'" class="values_default type1" type="text" value="'.$champ.'">';
				
			}
		
	
		if ($question_type==2) //paragraphe
			{
				$champ='';
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$champ=$row2['valeur'];}
				echo '<textarea class="type2" name="champ'.$row2['id'].'">'.$champ.'</textarea>'; 
			}
	
		if ($question_type==3) //choix multiple (radio)
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<div class="elmt_box"><input type="radio" name="radio'.$qid.'"><input name="champ'.$row2['id'].'" class="values_default type3" type="text" value="'.$row2['valeur'].'">
				<input name="suppr'.$row2['id'].'" class="supprval" type="submit" value="+" title="Supprimer"></div>';
				
				}
				
				echo '<input type="radio" name="radio'.$qid.'"><input name="radionew'.$qid.'" type="text" class="values_default type3" value="" placeholder="Ajouter nouvelle valeur" >';//add new
			}
	
		if ($question_type==4) //cases à cocher (checkbox)
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<div class="elmt_box"><input type="checkbox"><input name="champ'.$row2['id'].'" type="text" class="values_default type3" value="'.$row2['valeur'].'">
				<input name="suppr'.$row2['id'].'" class="supprval" type="submit" value="+" title="Supprimer"></div>'; }
				echo '<input type="checkbox"><input name="chknew'.$qid.'" type="text" value="" class="values_default type3" placeholder="Ajouter nouvelle valeur" >';//add new
			}
		
		if ($question_type==5) //Liste déroulante
			{
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
				echo '<ol>';
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {echo '<li><input name="champ'.$row2['id'].'" type="text" class="values_default type3" value="'.$row2['valeur'].'">
				<input name="suppr'.$row2['id'].'" class="supprval" type="submit" value="+" title="Supprimer"></li>'; }
				echo '<li><input name="listnew'.$qid.'" type="text" value="" class="values_default type3" placeholder="Ajouter nouvelle valeur" ></li>';//add new
				echo '</ol>';
			}
		
		if ($question_type==6) //échelle linéaire
			{
				
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=1 ORDER BY valeur ASC LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$min=(int)$row2['valeur'];$minid=$row2['id'];}
				
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=1 ORDER BY valeur DESC LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$max=(int)$row2['valeur'];$maxid=$row2['id'];}
				
				if (!$minid && !$maxid){//si pas encore de valeurs -> valeurs par défaut 0 - 5
					$min=0;$max=5;
					$addnewvalue = $db->exec("INSERT INTO data(question_id, valeur,is_secondary,datecreated) VALUES('$qid', 0,1,'$now')");$minid = $db->lastInsertId();
					$addnewvalue = $db->exec("INSERT INTO data(question_id, valeur,is_secondary,datecreated) VALUES('$qid', 5,1,'$now')");$maxid=$db->lastInsertId();}
				
					echo 'Echelle de valeur de <input type="number" class="values_default align_center" name="min'.$qid.'" value="'.$min.'" MIN=-10 MAX=10> à ';
					echo '<input type="number" class="values_default align_center" name="max'.$qid.'" value="'.$max.'" MIN=-10 MAX=10>';
					echo '<input type="hidden" name="minid'.$qid.'" value="'.$minid.'">';
					echo '<input type="hidden" name="maxid'.$qid.'" value="'.$maxid.'">';
					
					
					
						
				
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
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0 LIMIT 1");
				$champ='';
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$champ=$row2['valeur'];}
				echo '<input type="date" class="values_default" name="champ'.$qid.'" value="'.$champ.'">';
			}
			
		if ($question_type==10) //Heure
			{
				$champ='';
				$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0 LIMIT 1");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {$champ=$row2['valeur'];}
				echo '<input type="time" class="values_default" name="champ'.$qid.'" value="'.$champ.'">';
			}
		
		
		
		
		
		//echo '<input type="submit" class="add_new_question" value="Ok">';
			
		echo '</div>';
		
		
		
?>
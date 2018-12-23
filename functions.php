<?php

//-----conversion date SQL en date FR : 2018-04-24 13:47:38 -> 24 juil 2018 ou "Aujourd'hui" ou "hier"
function datecourtfr($date_en){
	$date_temp=explode(" ",$date_en);
	$date_temp2=explode("-",$date_temp[0]);
	$noms_mois=array(0,'janv','fév','mars','avr','mai','juin','juil','août','sept','oct','nov','déc');
	if (date("Y-m-d")==$date_temp[0]){$affichemodif='Aujourd\'hui ';}
	else {if (date("Y-m-d", strtotime( '-1 days' ) )==$date_temp[0]){$affichemodif='Hier ';}
	else{$affichemodif=$date_temp2[2].' '.$noms_mois[(int)$date_temp2[1]].' '.$date_temp2[0];}}
	return $affichemodif;
	}


?>	
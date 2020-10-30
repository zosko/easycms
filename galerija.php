<?php
require_once('includes/konekcija/baza_konektor.php');
require_once('includes/glavna/gore.php'); 
if($id_galerija = $HTTP_GET_VARS['id'])
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM galerija_sliki WHERE id_galerija='".$id_galerija."'");
	$k=0;
	echo '<table>';
	while ($row = $konektor->fetchArray($izlez))
	{
		if($k>3) 
		{
			$k=0;
			echo "<tr>";
		}
		echo '<td><a class="highslide" onclick="return hs.expand(this)" href="images/galerii/'.$row['slika'].'"><img width="140" height="100" src="images/galerii/_tumbs/'.$row['slika'].'" alt="" /></a></td>';
		$k++;
	}
	echo '</table>';
}
else
{
}
require_once('includes/glavna/dole.php');
?>
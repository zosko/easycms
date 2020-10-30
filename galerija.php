<?php
require_once('includes/konekcija/baza_konektor.php');
require_once('includes/glavna/gore.php'); 
if($id_galerija = $_GET['id'])
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM galerija_sliki WHERE id_galerija='".$id_galerija."'");
	$k=0;
	while ($row = $konektor->fetchArray($izlez))
	{
		if($k>3) 
		{
			$k=0;
			echo "<br />";
		}
		echo '<a href="images/galerii/'.$row['slika'].'" rel="lightbox[roadtrip]"><img src="images/galerii/_tumbs/'.$row['slika'].'" alt="" /></a>';
		$k++;
	}
	echo '';
}
else
{
}
require_once('includes/glavna/dole.php');
?>
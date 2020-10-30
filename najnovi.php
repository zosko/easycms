<?php 
require_once('includes/glavna/gore.php'); 
require_once('includes/konekcija/baza_konektor.php');

//ПРИКАЖУВАЊЕ ДЕНЕШНИ ВЕСТИ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE datum = '".date("Y-m-d")."'");
echo '<h4 class="title-039">'.$row_jazik['NEWS_TODAY'].'</h4>';
while($row = $konektor->fetchArray($izlez))
{
	$sodrzina = strip_tags(substr($row['sodrzina'], 0, 140))."...";
	echo '<div class="in">
				<div class="box">
					<div id="topstory-img2">
						<a href="vest-'.$row['id'].'.html"><img border="0" width="250" height="150" src="images/vest/'.$row['slika'].'"/></a>
					</div>
					<div id="topstory-txt2">
						<h3><a href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h3>
						<p class="nomb">'.$sodrzina.'</p>
					</div>
				</div>
			</div>';
}
require_once('includes/glavna/dole.php'); 
?>

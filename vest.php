<?php 
require_once('includes/glavna/gore.php'); 
require_once('includes/konekcija/baza_konektor.php');

//ЗА БРОЕЊЕ НА КЛИКОВИ НА ВЕСТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE id='".$_GET['id']."'");
$row = $konektor->fetchArray($izlez);
$click = $row['click'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE vest SET click='".$click."' WHERE id='".$_GET['id']."'"); 

//ПРИКАЖУВАЊЕ ВЕСТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE id='".$_GET['id']."'");
$row = $konektor->fetchArray($izlez);
$sekcija = $row['sekcija'];

echo '<h2 class="title-01">'.$row['naslov'].'</h2>
	<div class="in">
		<div class="box">
			<div id="topstory-img">
				<a href="images/vest/'.$row['golema_slika'].'" rel="lightbox"><img src="images/vest/'.$row['slika'].'"/></a>
			</div>
			<div id="topstory-txt">
				<p id="topstory-info">Published on: <strong>'.$row['datum'].'</strong></p>
				<p id="topstory-info">Visited: <b>'.$click.'</b> times
				<p id="topstory-info">Source: <b>'.$row['napisana_od'].'</b></p>
				<p class="nomb"><br /><br />'.$row['voved'].''.$row['sodrzina'].'</p>
			</div>
		</div>
	</div>';
$konektor_vesti_pod_statija_modul = new baza_konektor();
$izlez_vesti_pod_statija_modul = $konektor_vesti_pod_statija_modul->query("SELECT * FROM podesuvanja");
$row_vesti_pod_statija_modul = $konektor_vesti_pod_statija_modul->fetchArray($izlez_vesti_pod_statija_modul);
if($row_vesti_pod_statija_modul['vesti_pod_statija_modul'] == "1")
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcija."' ORDER BY id DESC LIMIT 5");
	echo '<h4 class="title-039">Last articles from this category</h4>';
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
}
require_once('includes/glavna/dole.php'); 
?>

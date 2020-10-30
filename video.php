<?php
require_once('includes/konekcija/baza_konektor.php');

if(isset($_GET['id'])){
//ЗА БРОЕЊЕ НА КЛИКОВИ НА ВИДЕО
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM video WHERE id='".$_GET['id']."'");
$row = $konektor->fetchArray($izlez);
$click = $row['click'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE video SET click='".$click."' WHERE id='".$_GET['id']."'"); 	
}

//СТРАНИЧЕЊЕ
$max = 10;
$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
$limits = ($strana - 1) * $max;

require_once('includes/glavna/gore.php');
if(isset($_GET['id']) && $id_klip = $_GET['id'])
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM video WHERE id='".$id_klip."'");
	$row = $konektor->fetchArray($izlez);
	echo '<h4 class="title-039">'.$row['naslov'].'</h4><br />';
	echo '<div class="content-box box"><center>'.$row['sodrzina'].'<br /><br />';
	echo '<object width="500" height="400">
	<embed src="'.$row['link'].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="400" />
	</object>
	</center></div>';
}
else
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' ORDER BY ID DESC LIMIT ".$limits.",$max");
	$res = $konektor->query("SELECT COUNT(id) FROM video");	
	$totalres = sizeof($res->fetch_array(MYSQLI_NUM));

	$totalpages = ceil($totalres / $max);
	while ($row = $konektor->fetchArray($izlez))
	{
		$sodrzina = strip_tags(substr($row['sodrzina'], 0, 140))."...";
		echo	'<div class="in">
					<div class="box">
						<div id="topstory-img3">
							<a href="video-'.$row['id'].'.html"><img border="0" src="images/video/'.$row['slika'].'"/></a>
						</div>
						<div id="topstory-txt3">
							<h3><a href="video-'.$row['id'].'.html">'.$row['naslov'].'</a></h3>
							<p class="nomb">'.$sodrzina.'</p>
						</div>
					</div>
				</div>';
	}
	echo '<div id="tnt_pagination">';
	echo '<a href="video.php?sekcija='.$sekcija_vid.'&strana='.($strana - 1).'">Prev</a>';
	for($i=1;$i<=$totalpages;$i++)
	{
		echo '<a href="video.php?sekcija='.$sekcija_vid.'&strana='.$i.'">'.$i.'</a>';
	}
	echo '<a href="video.php?sekcija='.$sekcija_vid.'&strana='.($strana + 1).'">Next</a>';
	echo '</div>';
}
require_once('includes/glavna/dole.php'); 
?>

<?php 
require_once('includes/glavna/gore.php'); 
require_once('includes/konekcija/baza_konektor.php');

//ЗА БРОЕЊЕ НА КЛИКОВИ НА ВЕСТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE id='".$HTTP_GET_VARS['id']."'");
$row = $konektor->fetchArray($izlez);
$click = $row['click'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE vest SET click='".$click."' WHERE id='".$HTTP_GET_VARS['id']."'"); 

//ПРИКАЖУВАЊЕ ВЕСТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE id='".$HTTP_GET_VARS['id']."'");
$row = $konektor->fetchArray($izlez);
$sekcija = $row['sekcija'];
$urlLink .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
echo '<h2 class="title-01">'.$row['naslov'].'</h2>
	<div class="in">
		<div class="box">
			<div id="topstory-img">
				<img src="images/vest/'.$row['slika'].'"/>
			</div>
			<div id="topstory-txt">
				<p id="topstory-info">'.$row_jazik['PUBLISHED_ON'].': <strong>'.$row['datum'].'</strong></p>
				<p id="topstory-info">'.$row_jazik['VISITED'].': <b>'.$click.'</b> '.$row_jazik['TIMES'].'
				<p id="topstory-info">'.$row_jazik['SOURCE'].': <b>'.$row['napisana_od'].'</b></p>
				<p id="topstory-info">'.$row_jazik['SHARE_ON'].': 
					<a target="_blank" href="http://www.facebook.com/share.php?u=http://'.$urlLink.'"><img border="0" src="images/spodeli/facebook.gif"/></a>
					<a target="_blank" href="http://technorati.com/faves?add=http://'.$urlLink.'"><img border="0" src="images/spodeli/technorati.png"/></a>
					<a target="_blank" href="http://digg.com/submit?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/digg.gif"/></a>
					<a target="_blank" href="http://kajmakot.softver.org.mk/prijavi/?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/kajmakot.png"/></a>
					<a target="_blank" href="http://www.stumbleupon.com/newurl.php?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/stumble.gif"/></a>
					<a target="_blank" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u=http://'.$urlLink.'"><img border="0" src="images/spodeli/yahoomyweb.png"/></a>
				</p>
				<p class="nomb"><br /><br /><b>'.$row['voved'].'</b><br /><br />'.$row['sodrzina'].'</p>
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
	echo '<h4 class="title-039">'.$row_jazik['LAST_ARTICLES'].'</h4>';
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

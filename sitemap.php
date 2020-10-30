<?php
require_once('includes/konekcija/baza_konektor.php');
require_once('includes/glavna/gore.php');

echo '<center><h4 class="title-03">Sitemap</h4></center><br />';


//КАТЕГОРИИ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM sekcija WHERE objavi='1'");
echo '&nbsp;&nbsp;&nbsp;<img src="images/design/news-dt.gif" /><b> Category:</b><br />';
while($row = $konektor->fetchArray($izlez))
{
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="sekcija-'.$row['id'].'.html"><img src="images/design/subnav.gif" /> '.$row['ime'].'</a><br />';
}
echo '<br />';
//ЛИНКОВИ
echo '&nbsp;&nbsp;&nbsp;<img src="images/design/news-dt.gif" /><b> Other links:</b><br />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="images/design/subnav.gif" /> <a href="./">Home</a> <br />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="images/design/subnav.gif" /> <a href="kontakt">Contact</a> <br />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="images/design/subnav.gif" /> <a href="denesni">News today</a> <br />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="images/design/subnav.gif" /> <a href="rss">RSS</a><br />';
$konektor_videoteka_modul = new baza_konektor();
$izlez_videoteka_modul = $konektor_videoteka_modul->query("SELECT * FROM podesuvanja");
$row_videoteka_modul = $konektor_videoteka_modul->fetchArray($izlez_videoteka_modul);
if($row_videoteka_modul['videoteka_modul'] == "1")
{
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="images/design/subnav.gif" /> <a href="videoteka">Videos</a> <br />';
}
$konektor_galerija_modul = new baza_konektor();
$izlez_galerija_modul = $konektor_galerija_modul->query("SELECT * FROM podesuvanja");
$row_galerija_modul = $konektor_galerija_modul->fetchArray($izlez_galerija_modul);
if($row_galerija_modul['galerija_modul'] == "1")
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM galerija WHERE objavi='1' ORDER BY ID DESC LIMIT 1");
	$row = $konektor->fetchArray($izlez);
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="images/design/subnav.gif" /> <a href="galerija-'.$row[id].'.html">Gallery</a> <br />';
}



require_once('includes/glavna/dole.php'); 
?>

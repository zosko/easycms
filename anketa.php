<?php
require_once('includes/konekcija/baza_konektor.php');

$ip_adresa = $_SERVER['REMOTE_ADDR'];

//ЈАЗИК
$konektor_jazik = new baza_konektor();
$izlez_jazik = $konektor_jazik->query("SELECT * FROM jazik");
$row_jazik = $konektor_jazik->fetchArray($izlez_jazik);

//ДОДАДИ ВО СТАТИСТИКА
$konektor = new baza_konektor();
$izlez = $konektor->query("INSERT INTO statistiki(ip_adresa_anketa,data) VALUES ('".$ip_adresa."','".date("Y-m-d")."')"); 

//ЗА БРОЕЊЕ НА ГЛАСОВИ НА АНКЕТА
$id_anketa_odgovor = $HTTP_GET_VARS['id'];
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM anketa_prasanja WHERE id='".$id_anketa_odgovor."'");
$row = $konektor->fetchArray($izlez);
$click = $row['glasovi'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE anketa_prasanja SET glasovi='".$click."' WHERE id='".$id_anketa_odgovor."'"); 


//РЕЗУЛТАТИ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM anketa WHERE objavi='1' ORDER BY ID DESC LIMIT 1");
$row_p = $konektor->fetchArray($izlez);
echo '<h4 class="title-04" style="margin-top:-36px;">'.$row_p['prasanje'].'</h4>
	<div class="in" style="margin-top:-15px;">
	<ul id="subnav">';
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM anketa_prasanja WHERE id_prasanje='".$row_p['id']."'");
$glasovi = 0;
while(($row = $konektor->fetchArray($izlez)))
{
	$glasovi += $row['glasovi'];
}
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM anketa_prasanja WHERE id_prasanje='".$row_p['id']."'");
while(($row = $konektor->fetchArray($izlez)))
{
	$zirina = 100*round($row['glasovi']/$glasovi,2);
	echo '<li><a><b>'.$row['odgovor'].'</b> <img src="images/design/anketa.gif" height="12" width="'.$zirina.'"> - '.$zirina.'%</a></li>';
}
echo '<center><b>'.$row_jazik['TOTAL_VOTES'].'</b> - '.$glasovi.'</center>
		</ul></div>';
?>

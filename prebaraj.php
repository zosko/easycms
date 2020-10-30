<?php 
require_once('includes/konekcija/baza_konektor.php'); 
require_once('includes/glavna/gore.php');

$baraj = $_POST['baraj'];
//$search = $_POST['baraj'];
//$latinica = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", ";", "'", "[", "]", "\\");
//$kirilica = array("а", "б", "ц", "д", "е", "ф", "г", "х", "и", "ј", "к", "л", "м", "н", "о", "п", "љ", "р", "с", "т", "у", "в", "њ", "џ", "ѕ", "з", "А", "Б", "Ц", "Д", "Е", "Ф", "Г", "Х", "И", "Ј", "К", "Л", "М", "Н", "О", "П", "Љ", "Р", "С", "Т", "У", "В", "Њ", "Џ", "Ѕ", "З", "ч", "ќ", "ш", "ѓ", "ж");
//$baraj = str_replace($latinica, $kirilica, $search);
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE sodrzina LIKE '%".$baraj."%' ORDER BY ID DESC LIMIT 10");
$projandeni = is_array($izlez->fetch_array(MYSQLI_NUM)) ? sizeof($izlez->fetch_array(MYSQLI_NUM)) : 0;
if($projandeni > 0)
{
	echo '<h4 class="title-039">Found articles</h4>';
	while ($row = $konektor->fetchArray($izlez))
	{
		$sodrzina = strip_tags(substr($row['sodrzina'], 0, 400))."...";
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
else
echo '<h4 class="title-039">No articles found</h4>';
require_once('includes/glavna/dole.php'); ?>
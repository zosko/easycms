<?php
require_once('includes/konekcija/baza_konektor.php');

//ЗА БРОЕЊЕ НА КЛИКОВИ НА ВИДЕО
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM video WHERE id='".$HTTP_GET_VARS['id']."'");
$row = $konektor->fetchArray($izlez);
$click = $row['click'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE video SET click='".$click."' WHERE id='".$HTTP_GET_VARS['id']."'"); 

//СТРАНИЧЕЊЕ
$max = 10;
$strana = $_GET['strana'];
if(empty($strana))
{
	$strana = 1;
}
$limits = ($strana - 1) * $max;

require_once('includes/glavna/gore.php');
if($id_klip = $HTTP_GET_VARS['id'])
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM video WHERE id='".$id_klip."'");
	$row = $konektor->fetchArray($izlez);
	$urlLink .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	echo '<h4 class="title-039">'.$row['naslov'].'</h4><br />';
	echo '<div class="content-box box"><center>'.$row['sodrzina'].'<br /><br />';
	echo '<object width="500" height="400">
	<param name="movie" value="http://youtube.com/v/'.$row['link'].'" />
	<param name="allowFullScreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<embed src="http://youtube.com/v/'.$row['link'].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="400" />
	</object>
	<br />'.$row_jazik['SHARE_ON'].':
	<a target="_blank" href="http://www.facebook.com/share.php?u=http://'.$urlLink.'"><img border="0" src="images/spodeli/facebook.gif"/></a>
	<a target="_blank" href="http://technorati.com/faves?add=http://'.$urlLink.'"><img border="0" src="images/spodeli/technorati.png"/></a>
	<a target="_blank" href="http://digg.com/submit?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/digg.gif"/></a>
	<a target="_blank" href="http://kajmakot.softver.org.mk/prijavi/?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/kajmakot.png"/></a>
	<a target="_blank" href="http://www.stumbleupon.com/newurl.php?url=http://'.$urlLink.'"><img border="0" src="images/spodeli/stumble.gif"/></a>
	<a target="_blank" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u=http://'.$urlLink.'"><img border="0" src="images/spodeli/yahoomyweb.png"/></a>
	</center></div>';
}
else
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' ORDER BY ID DESC LIMIT ".$limits.",$max");
	$totalres = mysql_result(mysql_query("SELECT COUNT(id) FROM video"),0);	
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
	if($totalpages>1)
	{
		echo '<div id="tnt_pagination">';
		echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.($strana - 1).'">'.$row_jazik['PREV'].'</a>';
		for($i=1;$i<=$totalpages;$i++)
		{
			echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.$i.'">'.$i.'</a>';
		}
		echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.($strana + 1).'">'.$row_jazik['NEXT'].'</a>';
		echo '</div>';
	}
}
require_once('includes/glavna/dole.php'); 
?>

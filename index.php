<?php 
require_once('includes/glavna/gore.php'); 
require_once('includes/konekcija/baza_konektor.php');

//БАНЕРОТ ВО СРЕДИНА
$konektor_reklama_sredina = new baza_konektor();
$izlez_reklama_sredina = $konektor_reklama_sredina->query("SELECT * FROM reklama WHERE polozba='1' AND objavi='1' ORDER BY ID DESC LIMIT 1");
$row_reklama_sredina = $konektor_reklama_sredina->fetchArray($izlez_reklama_sredina);

//СТРАНИЧЕЊЕ
$max = 10;
$strana = $_GET['strana'];
if(empty($strana))
{
	$strana = 1;
}
$limits = ($strana - 1) * $max * 2;
$limitsz = $limits + $max;	
if($sekcija_vid = $HTTP_GET_VARS['sekcija'])
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcija_vid."' AND objavi='1' ORDER BY ID DESC LIMIT ".$limits.",$max");
	$izlez1 = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcija_vid."' AND objavi='1' ORDER BY ID DESC LIMIT ".$limitsz.",$max");
	$totalres = mysql_result(mysql_query("SELECT COUNT(id) FROM vest WHERE sekcija='".$sekcija_vid."'"),0);	
	$totalpages = ceil($totalres /( $max * 2));
	echo	'<div class="in">
				<div class="cols5050 box">
				<div class="col">';
	while ($row = $konektor->fetchArray($izlez))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
					<p>'.$voved.'</p>
				</div>
			</div>';
	}
	echo '</div>';
	echo '<div class="col f-right">';
	while ($row = $konektor->fetchArray($izlez1))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
					<p>'.$voved.'</p>
				</div>
			</div>';
	}
	echo '</div> 
			</div>
				</div>';
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
else
{
	$konektor_modul_news_flash = new baza_konektor();
	$izlez_modul_news_flash = $konektor_modul_news_flash->query("SELECT * FROM podesuvanja");
	$row_modul_news_flash = $konektor_modul_news_flash->fetchArray($izlez_modul_news_flash);
	if($row_modul_news_flash['news_flash_modul'] == "1")
	{
		$konektor_flash_vest = new baza_konektor();
		$izlez_flash_vest = $konektor_flash_vest->query("SELECT * FROM flash_news WHERE id='1'");
		$row_flash_vest = $konektor_flash_vest->fetchArray($izlez_flash_vest);
		//ДЕЛОТ НАД ТОПВЕСТИ ШТО СЕ ДВИЖИ
		echo '<p id="breadcrumbs"><b>'.$row_jazik['FLASH_NEWS'].'</b>:';
		echo '<div id="scroller_container"><div id="scroller">'.$row_flash_vest['text'].'</div></div>';
		echo '</p>';
	}
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE objavi='1' AND glavna='0' ORDER BY ID DESC LIMIT 6");
	$izlez1 = $konektor->query("SELECT * FROM vest WHERE objavi='1' AND glavna='0' ORDER BY ID DESC LIMIT 6,6");
	

		//ТОП ВЕСТ ОД ТУКА
		$konektor_top_vest = new baza_konektor();
		$izlez_top_vest = $konektor_top_vest->query("SELECT * FROM vest WHERE glavna='1' AND objavi='1' ORDER BY ID DESC LIMIT 1");
		$row_top_vest = $konektor_top_vest->fetchArray($izlez_top_vest);
			$voved_top_vest = strip_tags(substr($row_top_vest['voved'], 0, 500))."...";
			echo '<h2 class="title-01">'.$row_jazik['TOP_NEWS'].'</h2><div class="in">';
	$konektor_modul_top_vest = new baza_konektor();
	$izlez_modul_top_vest = $konektor_modul_top_vest->query("SELECT * FROM podesuvanja");
	$row_modul_top_vest = $konektor_modul_top_vest->fetchArray($izlez_modul_top_vest);
	if($row_modul_top_vest['top_novost_modul'] == "1")
	{
					echo	'<div class="box">
							<div id="topstory-img2">
								<a href="vest-'.$row_top_vest['id'].'.html"><img border="0" width="250" height="150" src="images/vest/'.$row_top_vest['slika'].'"/></a>
							</div>
							<div id="topstory-txt2">
								<h3><a href="vest-'.$row_top_vest['id'].'.html">'.$row_top_vest['naslov'].'</a></h3>
								<p class="nomb">'.$voved_top_vest.'</p>
							</div>
						</div>';
		//ТОП ВЕСТ ДО ТУКА
	} //ZA modulot TOP VEST
	$konektor_reklami_modul = new baza_konektor();
	$izlez_reklami_modul = $konektor_reklami_modul->query("SELECT * FROM podesuvanja");
	$row_reklami_modul = $konektor_reklami_modul->fetchArray($izlez_reklami_modul);
	if($row_reklami_modul['reklami_modul'] == "1")
	{
		echo '<a href="reklama-'.$row_reklama_sredina['id'].'.html" target="_blank" border="0"><img style="margin-top:5px;" border="0" src="images/reklami/'.$row_reklama_sredina['link'].'" /></a>';
	}
			echo '<div class="cols5050 box">
				<div class="col">';
	while ($row = $konektor->fetchArray($izlez))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
					<p>'.$voved.'</p>
				</div>
			</div>';
	}
	echo '</div>
			<div class="col f-right">';
	while ($row = $konektor->fetchArray($izlez1))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
					<p>'.$voved.'</p>
				</div>
			</div>';
	}
	echo '</div> 
			</div>
				</div>';
}
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM reklama WHERE polozba='2' AND objavi='1' ORDER BY ID DESC LIMIT 1");
	$row = $konektor->fetchArray($izlez);
	if($row_reklami_modul['reklami_modul'] == "1")
	{
		echo '<a href="reklama-'.$row['id'].'.html" target="_blank" border="0"><img border="0" src="images/reklami/'.$row['link'].'" /></a>';
	}
?>
<div class="cols5050 box">
	<div class="col">
<?php
	$konektor_najcitani_vesti_modul = new baza_konektor();
	$izlez__najcitani_vesti_modul = $konektor_najcitani_vesti_modul->query("SELECT * FROM podesuvanja");
	$row__najcitani_vesti_modul = $konektor_najcitani_vesti_modul->fetchArray($izlez__najcitani_vesti_modul);
	if($row__najcitani_vesti_modul['najcitani_vesti_modul'] == "1")
	{
?>	
		<h4 class="title-03"><?php echo $row_jazik['POPULAR_NEWS'] ?></h4>
		<ul id="subnav">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM vest WHERE objavi='1' ORDER BY click DESC LIMIT 5");
				while ($row = $konektor->fetchArray($izlez))
				{
					$voved = addslashes(strip_tags(substr($row['voved'], 0, 100)))."...";
					echo '<li class="active"><a onmouseout="hidettip();" onmouseover="showttip(\'&lt;img width=&quot;140&quot; height=&quot;70&quot; src=&quot;images/vest/'.$row['slika'].'&quot; align=&quot;left&quot;/&gt;'.$voved.'\', 270);" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></li>';
				}
			?>
		</ul>
<?php } //za najcitani vesti modulot ?>
<?php
	$konektor_modul_rss = new baza_konektor();
	$izlez_modul_rss = $konektor_modul_rss->query("SELECT * FROM podesuvanja");
	$row_modul_rss = $konektor_modul_rss->fetchArray($izlez_modul_rss);
	if($row_modul_rss['rss_modul'] == "1")
	{
?>	
		<h4 class="title-04"><?php echo $row_jazik['RSS_NEWS'] ?></h4>
		<div class="in">
		<dl id="news" class="box">
		<?php
		$konektor = new baza_konektor();
		$izlez = $konektor->query("SELECT * FROM podesuvanja");
		$row = $konektor->fetchArray($izlez);
		$xml= $row['rss_url'];
		if($xml == "")
		{
		}
		else
		{
			$xmlDoc = new DOMDocument();
			$xmlDoc->load($xml);
			$x=$xmlDoc->getElementsByTagName('item');
			for ($i=0; $i<=4; $i++)
			{
				$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				$item_desc=$x->item($i)->getElementsByTagName('description')  ->item(0)->childNodes->item(0)->nodeValue;
				echo "<dd><img src=\"images/design/news-dt.gif\" /> <a target=\"_blank\" href='".$item_link."'>".$item_title."</a></dd>";
			}
		}
		?>
		</dl>
		</div>
<?php } //za rss modulot ?>
	</div>
	<div class="col f-right">
<?php
	$konektor_najgledani_videa_modul = new baza_konektor();
	$izlez_najgledani_videa_modul = $konektor_najgledani_videa_modul->query("SELECT * FROM podesuvanja");
	$row_najgledani_videa_modul = $konektor_najgledani_videa_modul->fetchArray($izlez_najgledani_videa_modul);
	if($row_najgledani_videa_modul['najgledani_videa_modul'] == "1")
	{
?>	
		<h4 class="title-03"><?php echo $row_jazik['POPULAR_VIDEOS'] ?></h4>
		<ul id="subnav">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' ORDER BY click DESC LIMIT 5");
				while ($row = $konektor->fetchArray($izlez))
				{
					$sodrzina = addslashes(strip_tags(substr($row['sodrzina'], 0, 100)))."...";
					echo '<li class="active"><a onmouseout="hidettip();" onmouseover="showttip(\'&lt;img width=&quot;140&quot; height=&quot;70&quot; src=&quot;images/video/'.$row['slika'].'&quot; align=&quot;left&quot;/&gt;'.$sodrzina.'\', 270);" href="video-'.$row['id'].'.html">'.$row['naslov'].'</a></li>';
				}
			?>
		</ul>
<?php } //za najgledani videa modulot ?>
<?php
	$konektor_modul_twit = new baza_konektor();
	$izlez_modul_twit = $konektor_modul_twit->query("SELECT * FROM podesuvanja");
	$row_modul_twit = $konektor_modul_twit->fetchArray($izlez_modul_twit);
	if($row_modul_twit['twit_modul'] == "1")
	{
?>
		<h4 class="title-04"><?php echo $row_jazik['TWEETS'] ?></h4>
		<dl id="news" class="box">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM podesuvanja");
				$row = $konektor->fetchArray($izlez);
				//require_once("includes/twitter/JSON.php");  //aktiviraj za verzii pomali od PHP 5.2
				$twitter_user = $row['twit_user'];
				if($twitter_user == "")
				{
					echo '';
				}
				else
				{
					$path = 'http://twitter.com/statuses/user_timeline/'.$twitter_user.'.json?count=5';
					$jason = file_get_contents($path);
					$arr = json_decode($jason);
					for($i=0;$i<3;$i++)
					{
						$object = get_object_vars($arr[$i]);
						$link_vo_twit = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $object['text']);
						$datum_postirano = explode(" ",$object['created_at']);
						echo '<dt>'.$datum_postirano[0].' '.$datum_postirano[1].' '.$datum_postirano[2].' '.$datum_postirano[3].'</dt>
							<dd>'.$link_vo_twit.'</dd>';
					}
				}
			?>
		</dl>
	<?php } //za twiter modulot?>
	</div>
</div>
<?php require_once('includes/glavna/dole.php'); ?>
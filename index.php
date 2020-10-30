<?php 
require_once('includes/glavna/gore.php'); 
require_once('includes/konekcija/baza_konektor.php');

//БАНЕРОТ ВО СРЕДИНА
$konektor_reklama_sredina = new baza_konektor();
$izlez_reklama_sredina = $konektor_reklama_sredina->query("SELECT * FROM reklama WHERE polozba='1' AND objavi='1' ORDER BY ID DESC LIMIT 1");
$row_reklama_sredina = $konektor_reklama_sredina->fetchArray($izlez_reklama_sredina);

//СТРАНИЧЕЊЕ
$max = 10;
$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
$limits = ($strana - 1) * $max * 2;
$limitsz = $limits + $max;

if(isset($_GET['sekcija'])){
	$sekcija_vid = $_GET['sekcija'];
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcija_vid."' AND objavi='1' ORDER BY ID DESC LIMIT ".$limits.",$max");
	$izlez1 = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcija_vid."' AND objavi='1' ORDER BY ID DESC LIMIT ".$limitsz.",$max");

	$res = $konektor->query("SELECT COUNT(id) FROM vest WHERE sekcija='".$sekcija_vid."'");	
	$totalres = sizeof($res->fetch_array(MYSQLI_NUM));
	$totalpages = ceil($totalres /( $max * 2));
	echo	'<div class="in">
				<div class="cols5050 box">
				<div class="col">';
	while ($row = $konektor->fetchArray($izlez))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
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
					<a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
					<p>'.$voved.'</p>
				</div>
			</div>';
	}
	echo '</div> 
			</div>
				</div>';
				
	echo '<div id="tnt_pagination">';
	echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.($strana - 1).'">Prev</a>';
	for($i=1;$i<=$totalpages;$i++)
	{
		echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.$i.'">'.$i.'</a>';
	}
	echo '<a href="index.php?sekcija='.$sekcija_vid.'&strana='.($strana + 1).'">Next</a>';
	echo '</div>';
}
else
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE objavi='1' AND glavna='0' ORDER BY ID DESC LIMIT 6");
	$izlez1 = $konektor->query("SELECT * FROM vest WHERE objavi='1' AND glavna='0' ORDER BY ID DESC LIMIT 6,6");
	

		//ТОП ВЕСТ ОД ТУКА
		$konektor_top_vest = new baza_konektor();
		$izlez_top_vest = $konektor_top_vest->query("SELECT * FROM vest WHERE glavna='1' AND objavi='1' ORDER BY ID DESC LIMIT 1");
		$row_top_vest = $konektor_top_vest->fetchArray($izlez_top_vest);
			$voved_top_vest = strip_tags(substr($row_top_vest['voved'], 0, 500))."...";
			echo '<div class="in">';
	$konektor_modul_top_vest = new baza_konektor();
	$izlez_modul_top_vest = $konektor_modul_top_vest->query("SELECT * FROM podesuvanja");
	$row_modul_top_vest = $konektor_modul_top_vest->fetchArray($izlez_modul_top_vest);
	if($row_modul_top_vest['top_novost_modul'] == "1")
	{
					echo	'<div class="box">
							<div id="topstory-img2">
								<a title="Visited '.$row_top_vest['click'].' times" href="vest-'.$row_top_vest['id'].'.html"><img border="0" width="250" height="150" src="images/vest/'.$row_top_vest['slika'].'"/></a>
							</div>
							<div id="topstory-txt2">
								<h3><a title="Visited '.$row_top_vest['click'].' times" href="vest-'.$row_top_vest['id'].'.html">'.$row_top_vest['naslov'].'</a></h3>
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
		echo '<a href="reklama-'.$row_reklama_sredina['id'].'.html" target="_blank" border="0"><img border="0" src="images/reklami/'.$row_reklama_sredina['link'].'" /></a>';
	}
			echo '<div class="cols5050 box">
				<div class="col">';
	while ($row = $konektor->fetchArray($izlez))
	{
		$voved = strip_tags(substr($row['voved'], 0, 100))."...";
		echo '<div class="article box">
				<div class="article-img">
					<a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
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
					<a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html"><img border="0" src="images/vest/'.$row['slika'].'" height="86" width="85" /></a>
				</div>
				<div class="article-txt">
					<h4><a title="Visited '.$row['click'].' times" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></h4>
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
	if(isset($row_reklami_modul['reklami_modul']) && $row_reklami_modul['reklami_modul'] == "1")
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
		<h4 class="title-03">Popular news this week</h4>
		<ul id="subnav">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM vest WHERE objavi='1' ORDER BY click DESC LIMIT 5");
				while ($row = $konektor->fetchArray($izlez))
				{
					echo '<li class="active"><a onmouseout="hidettip();" onmouseover="showttip(\'&lt;img width=&quot;140&quot; height=&quot;70&quot; src=&quot;images/vest/'.$row['slika'].'&quot; align=&quot;left&quot;/&gt;'.$row['voved'].'\', 270);" href="vest-'.$row['id'].'.html">'.$row['naslov'].'</a></li>';
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
		<h4 class="title-04">RSS news</h4>
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
			for ($i=0; $i<=3; $i++)
			{
				$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				// $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
				echo "<dd><a target=\"_blank\" href='".$item_link."'>".$item_title."</a></dd>";
			}
		}
		?>
		</dl>
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
		<h4 class="title-03">Popular videos this week</h4>
		<ul id="subnav">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' ORDER BY click DESC LIMIT 5");
				while ($row = $konektor->fetchArray($izlez))
				{
					echo '<li class="active"><a onmouseout="hidettip();" onmouseover="showttip(\'&lt;img width=&quot;140&quot; height=&quot;70&quot; src=&quot;images/video/'.$row['slika'].'&quot; align=&quot;left&quot;/&gt;'.$row['sodrzina'].'\', 270);" href="video-'.$row['id'].'.html">'.$row['naslov'].'</a></li>';
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
		<h4 class="title-04">Tweets</h4>
		<dl id="news" class="box">
			<?php
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM podesuvanja");
				$row = $konektor->fetchArray($izlez);
				require_once("includes/twitter/JSON.php");
				require_once("includes/twitter/TwitterCacher.php");
				$twEmail = $row['twit_user'];
				$twPass = $row['twit_pass'];
				$json = new Services_JSON();
				if($twEmail == "" || $twPass == "")
				{
				}
				else
				{
					$tc = new TwitterCacher($twEmail,$twPass);
					$tc->setUserAgent("Mozilla/5.0 (compatible; TwitterCacher/1.0;)");
					$timeline = $json->decode( $tc->getUserTimeline() );
					$i=0;
					foreach( $timeline as $tweet ) 
					{
						if($i>2){break;}
						else
						{
							$text = $tweet->text;
							$date = date('M j, Y @ h:i A', strtotime($tweet->created_at));
							echo '<dt>'.$date.'<dt/><dd>'.$text.'<dd>';
						}
						$i++;
					}
				}
			?>
		</dl>
	<?php } //za twiter modulot?>
	</div>
</div>
<?php require_once('includes/glavna/dole.php'); ?>
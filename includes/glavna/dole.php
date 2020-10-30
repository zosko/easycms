           </div>
            <hr class="noscreen" />
            <div id="aside">
                <h4 class="title-03"><?php echo $row_jazik['CATEGORY'] ?></h4>
                <div class="in">
                    <ul id="subnav">
                        <li class="active1"><a href="pocetna"><?php echo $row_jazik['HOME'] ?></a></li>
						<?php
							$konektor = new baza_konektor();
							$izlez = $konektor->query("SELECT * FROM sekcija WHERE objavi='1'");
							while ($row = $konektor->fetchArray($izlez))
							{
								echo '<li class="active1" ><a href="sekcija-'.$row['id'].'.html">'.$row['ime'].'</a></li>';
							}
						?>
                    </ul>
                </div>
<?php
	$konektor_top_video_modul = new baza_konektor();
	$izlez_top_video_modul = $konektor_top_video_modul->query("SELECT * FROM podesuvanja");
	$row_top_video_modul = $konektor_top_video_modul->fetchArray($izlez_top_video_modul);
	if($row_top_video_modul['top_video_modul'] == "1")
	{
?>	
                <div class="in" style="margin-top:-25px;margin-left:-15px">
				<?php
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' AND top='1' ORDER BY ID DESC LIMIT 1");
					$row = $konektor->fetchArray($izlez);
					echo '<object width="280" height="220">
							<param name="movie" value="http://youtube.com/v/'.$row['link'].'"></param>
							<param name="allowFullScreen" value="true"></param>
							<param name="allowscriptaccess" value="always"></param>
							<embed src="http://youtube.com/v/'.$row['link'].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="280" height="220"></embed>
							</object>';
				?>
                </div>
<?php } //za TOP video modulot ?>

<?php
	$konektor_random_vesti_modul = new baza_konektor();
	$izlez_random_vesti_modul = $konektor_random_vesti_modul->query("SELECT * FROM podesuvanja");
	$row_random_vesti_modul = $konektor_random_vesti_modul->fetchArray($izlez_random_vesti_modul);
	if($row_random_vesti_modul['random_vesti_modul'] == "1")
	{
?>	
				<div class="in" style="margin-top:-30px;margin-left:-15px">
				<div id="vesti-desno">
					<ul>
						<?php
							$konektor = new baza_konektor();
							$izlez = $konektor->query("SELECT * FROM vest WHERE objavi='1' ORDER BY RAND() LIMIT 40");
							while(($row = $konektor->fetchArray($izlez)))
							{
								$voved = addslashes(strip_tags(substr($row['voved'], 0, 100)))."...";
								echo '<li style="width:260px;border: 1px solid #aaaaaa;">
										<div >
											<a onmouseout="hidettip();" onmouseover="showttip(\''.$voved.'\', 270);" href="vest-'.$row['id'].'.html"><img height="45" width="55" src="images/vest/'.$row['slika'].'"/><div style="margin-left:60px;margin-top:-40px">'.$row['naslov'].'</div><br /></a>
										</div>
									</li>';
							}
						?>
					</ul>
				</div>
				</div>
<?php } //za RANDOM vesti modulot ?>

<?php
	$konektor_radio_modul = new baza_konektor();
	$izlez_radio_modul = $konektor_radio_modul->query("SELECT * FROM podesuvanja");
	$row_radio_modul = $konektor_radio_modul->fetchArray($izlez_radio_modul);
	if($row_radio_modul['radio_modul'] == "1")
	{
?>	
				<div class="in" style="margin-top:-40px;">
					<div class="tabber">
						<div class="tabbertab">
							<h2><?php echo $row_jazik['HOME_RADIO'] ?></h2>
							<ul id="subnav">
								<?php 
									$konektor = new baza_konektor();
									$izlez = $konektor->query("SELECT * FROM radio WHERE vid='makedonsko' AND objavi='1'");
									while ($row = $konektor->fetchArray($izlez))
									{
										echo '<li class="active1"><a href="'.$row['link'].'" target="_blank">'.$row['ime'].'</a></li>';
									}
								?>
							</ul>
						</div>
						<div class="tabbertab">
							<h2><?php echo $row_jazik['OTHER_RADIO'] ?></h2>
							<ul id="subnav">
								<?php 
									$konektor = new baza_konektor();
									$izlez = $konektor->query("SELECT * FROM radio WHERE vid='stransko' AND objavi='1'");
									while ($row = $konektor->fetchArray($izlez))
									{
										echo '<li class="active1"><a href="'.$row['link'].'" target="_blank">'.$row['ime'].'</a></li>';
									}
								?>
							</ul>
						</div>
					</div>
				</div>
<?php } //za radio modulot ?>

<?php
	$konektor_videoteka_modul = new baza_konektor();
	$izlez_videoteka_modul = $konektor_videoteka_modul->query("SELECT * FROM podesuvanja");
	$row_videoteka_modul = $konektor_videoteka_modul->fetchArray($izlez_videoteka_modul);
	if($row_videoteka_modul['videoteka_modul'] == "1")
	{
?>	
				<h4 class="title-03" style="margin-top:-25px;"><a href="videoteka"><?php echo $row_jazik['VIDEOS'] ?></a></h4>
				<div class="in" >
					<table border="0" style="margin-left:-17px;margin-top:-18px;"><tr>
						<?php
							$konektor = new baza_konektor();
							$izlez = $konektor->query("SELECT * FROM video WHERE objavi='1' AND top='0' ORDER BY ID DESC LIMIT 4");
							while ($row = $konektor->fetchArray($izlez))
							{
								if($k7>1)
								{
									$k7=0;
									echo '</tr><tr>';
								}
								echo '<td width="139" height="100">';
								$sodrzina = addslashes(strip_tags(substr($row['sodrzina'], 0, 100)))."...";
								echo '<a onmouseover="showttip(\''.$sodrzina.'\', 270);" onmouseout="hidettip();"  href="video-'.$row['id'].'.html"><img border="0" width="139" src="images/video/'.$row['slika'].'"/></a>';
								echo '</td>';
								$k7++;
							}
						?>
					</table>
				</div>
<?php } //za videoteka modulot ?>

<?php
	$konektor_anketa_modul = new baza_konektor();
	$izlez_anketa_modul = $konektor_anketa_modul->query("SELECT * FROM podesuvanja");
	$row_anketa_modul = $konektor_anketa_modul->fetchArray($izlez_anketa_modul);
	if($row_anketa_modul['anketa_modul'] == "1")
	{
?>
				<?php
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM statistiki WHERE ip_adresa_anketa='".$ip_adresa."' ORDER BY ID DESC LIMIT 1");
					$row = $konektor->fetchArray($izlez);
					$denes = date("Y-m-d");
					if($row['data'] < $denes)
					{
						$konektor = new baza_konektor();
						$izlez = $konektor->query("SELECT * FROM anketa WHERE objavi='1' ORDER BY ID DESC LIMIT 1");
						$row = $konektor->fetchArray($izlez);
						echo '<div id="anketa"><h4 class="title-04" style="margin-top:-36px;">'.$row['prasanje'].'</h4>
							<form name="anketa" method="post" action="">
							<div class="in" style="margin-top:-15px;">
							<ul id="subnav">';
						$konektor = new baza_konektor();
						$izlez = $konektor->query("SELECT * FROM anketa_prasanja WHERE id_prasanje='".$row['id']."'");
						while(($row = $konektor->fetchArray($izlez)))
						{
							echo '<li><a><input type="radio" name="prasanje" onclick="anketa_glasaj(this.value)" id="prasanje" value="'.$row['id'].'">'.$row['odgovor'].'</a></li>';
						}
						echo '<center></center>
							</ul></div></form></div>';
					}
					else if($row['data'] == $denes || $row['data'] == "")
					{
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
					}
				?>
<?php } //za anketa modulot ?>
	
<?php
	$konektor_meteo_modul = new baza_konektor();
	$izlez_meteo_modul = $konektor_meteo_modul->query("SELECT * FROM podesuvanja");
	$row_meteo_modul = $konektor_meteo_modul->fetchArray($izlez_meteo_modul);
	if($row_meteo_modul['meteo_modul'] == "1")
	{
?>	
				<div class="in" style="margin-top:-35px;">
					<div id="weather">
						 <? include("includes/vreme/weather.php");?>
					</div>
					<select name="grad" id="grad" class="textSodrzina" onChange="showWeather()">
					<?php
						$konektor_meteo = new baza_konektor();
						$izlez_meteo = $konektor_meteo->query("SELECT * FROM meteo");
						$row_meteo = $konektor_meteo->fetchArray($izlez_meteo);
						echo '<option value="'.$row_meteo['code1'].'">&nbsp;'.$row_meteo['city1'].'</option>';
						echo '<option value="'.$row_meteo['code2'].'">&nbsp;'.$row_meteo['city2'].'</option>';
						echo '<option value="'.$row_meteo['code3'].'">&nbsp;'.$row_meteo['city3'].'</option>';
						echo '<option value="'.$row_meteo['code4'].'">&nbsp;'.$row_meteo['city4'].'</option>';
						echo '<option value="'.$row_meteo['code5'].'">&nbsp;'.$row_meteo['city5'].'</option>';
						echo '<option value="'.$row_meteo['code6'].'">&nbsp;'.$row_meteo['city6'].'</option>';
						echo '<option value="'.$row_meteo['code7'].'">&nbsp;'.$row_meteo['city7'].'</option>';
					?>
					</select>
				</div>
<?php } // za METEO modulot?>
			</div>
        </div>
    </div>
<?php
	$konektor_galerija_modul = new baza_konektor();
	$izlez_galerija_modul = $konektor_galerija_modul->query("SELECT * FROM podesuvanja");
	$row_galerija_modul = $konektor_galerija_modul->fetchArray($izlez_galerija_modul);
	if($row_galerija_modul['galerija_modul'] == "1")
	{
?>	
	<div id="gallery">
		<h4 class="title-03 gallery"><?php echo $row_jazik['LAST_GALLERY'] ?></h4>
		<div id="gallery-in">
			<p class="t-center nom box">
				<?php
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM galerija WHERE objavi='1' ORDER BY ID DESC LIMIT 6");
					while ($row = $konektor->fetchArray($izlez))
					{
						echo '<a href="galerija-'.$row['id'].'.html"><img border="0" src="images/galerii/_tumbs/'.$row['naslovna'].'"/></a>';
					}
				?>
			</p>
		</div>
	</div>
<?php } // za galerija modulot?>
<?php
	$konektor_tags_modul = new baza_konektor();
	$izlez_tags_modul = $konektor_tags_modul->query("SELECT * FROM podesuvanja");
	$row_tags_modul = $konektor_tags_modul->fetchArray($izlez_tags_modul);
	if($row_tags_modul['tags_modul'] == "1")
	{
?>
	<div class="separator"></div>
	<div id="gallery-in">
		<div class="box">
		<?php
			echo '<p class="f-left nom">'.$row_jazik['TAGS'].': ';
			$konektor = new baza_konektor();
			$izlez = $konektor->query("SELECT * FROM prebaraj ORDER BY brojac DESC LIMIT 20");
			while ($row = $konektor->fetchArray($izlez))
			{
				echo ' <a href="baraj-'.$row['zbor'].'.html">'.stripslashes($row['zbor']).'</a> ';
			}
			echo '</p>';
		?>
		</div>
	</div>
<?php } // za tags modulot?>
    <hr class="noscreen" />
	<div id="footer" class="box">
	<p class="f-right"><a href="sitemap" id="ico-sitemap"><?php echo $row_jazik['SITEMAP'] ?></a></p>
	<?php
			$konektor = new baza_konektor();
		$izlez = $konektor->query("SELECT * FROM podesuvanja");
	    $row = $konektor->fetchArray($izlez);
		echo '<p class="f-left">'.$row['footer'].'</p>';
	?>
	</div>
</div>
</body>
</html>
<?
if(file_exists("includes/konekcija/Podesi.php"))
	echo "<script>document.location.href='pocetna'</script>";
?>
<html>
<head>
<title>Installation EasyCMS</title>
</head>
<body >
<br /><br /><br /><br /><br />
<form method="post" action="">
<table align="center" width="50%" border="0" cellspacing="0" cellpadding="2">
<tr>
	<tr>
		<td>&nbsp;Database Host</td>
		<td>
			<input type="text" name="database_host" value="localhost" size="30" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;Database Name</td>
		<td>
			<input type="text" name="database_name" size="30" value="cms" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;Database Username</td>
		<td>
			<input type="text" name="database_username" size="30" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;Database Password</td>
		<td>
			<input type="password" name="database_password" size="30"/>
		</td>
	</tr>
	<tr>
		<td colspan=2 align='center'>
			<input type="submit" name="zapocni_instalacija" id="zapocni_instalacija" value="Install!">
		</td>
	</tr>
</table>
</form>
</body>
</html>
<?php
if(isset($_POST['zapocni_instalacija']))
{
	$host = $_POST['database_host'];
	$user = $_POST['database_username'];
	$pass = $_POST['database_password'];
	$name =$_POST['database_name'];
	
	$file = "includes/konekcija/Podesi.php";
	$fo = fopen($file,"w+") or die("Please make CHMOD 777 on folder includes/konekcija");
	$database_inf='<?php
	class Podesi 
	{
		var $podatok;
		function zemiPodatok() 
		{
			$podatok[\'baza_server\'] = "'.$host.'";
			$podatok[\'baza_user\'] = "'.$user.'";
			$podatok[\'baza_pass\'] = "'.$pass.'";
			$podatok[\'baza_ime\'] = "'.$name.'";
			return $podatok;
		}
	}
	?>';
	if (@fwrite($fo,$database_inf)>0) 
	{
		fclose($fo);
		if (@mysql_connect($host,$user,$pass))
		{
			if (@mysql_select_db($name))
			{
				if(@mysql_query("CREATE TABLE IF NOT EXISTS `anketa` (
								  `id` int(11) NOT NULL auto_increment,
								  `prasanje` varchar(200) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;")!=0 &&

					@mysql_query("CREATE TABLE IF NOT EXISTS `anketa_prasanja` (
								  `id` int(11) NOT NULL auto_increment,
								  `id_prasanje` varchar(200) NOT NULL,
								  `odgovor` varchar(100) NOT NULL,
								  `glasovi` int(5) NOT NULL default '1',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;")!=0 &&
					
					@mysql_query("CREATE TABLE IF NOT EXISTS `flash_news` (
								  `id` int(11) NOT NULL auto_increment,
								  `text` varchar(1000) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;")!=0 &&
								
					@mysql_query("INSERT INTO `flash_news` (`id`, `text`) VALUES (1, 'Lorem ipsum');")!=0 &&			
					
					@mysql_query("CREATE TABLE IF NOT EXISTS `galerija` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(100) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  `naslovna` varchar(100) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `galerija_sliki` (
								  `id` int(11) NOT NULL auto_increment,
								  `id_galerija` int(11) NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=251 ;")!=0 &&
								
						@mysql_query("CREATE TABLE IF NOT EXISTS `jazik` (
					  `id` int(5) NOT NULL auto_increment,
					  `HOME` varchar(10) character set utf8 NOT NULL,
					  `CONTACT` varchar(20) character set utf8 NOT NULL,
					  `SEARCH` varchar(20) character set utf8 NOT NULL,
					  `TOP_NEWS` varchar(20) character set utf8 NOT NULL,
					  `CATEGORY` varchar(20) character set utf8 NOT NULL,
					  `HOME_RADIO` varchar(20) character set utf8 NOT NULL,
					  `OTHER_RADIO` varchar(20) character set utf8 NOT NULL,
					  `VIDEOS` varchar(20) character set utf8 NOT NULL,
					  `POPULAR_NEWS` varchar(20) character set utf8 NOT NULL,
					  `POPULAR_VIDEOS` varchar(20) character set utf8 NOT NULL,
					  `RSS` varchar(20) character set utf8 NOT NULL,
					  `RSS_NEWS` varchar(20) character set utf8 NOT NULL,
					  `TWEETS` varchar(20) character set utf8 NOT NULL,
					  `TOTAL_VOTES` varchar(20) character set utf8 NOT NULL,
					  `LAST_GALLERY` varchar(20) character set utf8 NOT NULL,
					  `NAME` varchar(20) character set utf8 NOT NULL,
					  `EMAIL` varchar(20) character set utf8 NOT NULL,
					  `SUBJECT` varchar(20) character set utf8 NOT NULL,
					  `MESSAGE` varchar(20) character set utf8 NOT NULL,
					  `SEND_MESSAGE` varchar(20) character set utf8 NOT NULL,
					  `NEXT` varchar(20) character set utf8 NOT NULL,
					  `PREV` varchar(20) character set utf8 NOT NULL,
					  `PUBLISHED_ON` varchar(20) character set utf8 NOT NULL,
					  `VISITED` varchar(20) character set utf8 NOT NULL,
					  `TIMES` varchar(20) character set utf8 NOT NULL,
					  `SOURCE` varchar(20) character set utf8 NOT NULL,
					  `SHARE_ON` varchar(20) character set utf8 NOT NULL,
					  `LAST_ARTICLES` varchar(40) character set utf8 NOT NULL,
					  `FOUND_ARTICLES` varchar(20) character set utf8 NOT NULL,
					  `NEWS_TODAY` varchar(40) character set utf8 NOT NULL,
					  `VISITS_TODAY` varchar(50) character set utf8 NOT NULL,
					  `FLASH_NEWS` varchar(50) character set utf8 NOT NULL,
					  `TAGS` varchar(20) character set utf8 NOT NULL,
					  `SITEMAP` varchar(50) character set utf8 NOT NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;")!=0 &&
					
			@mysql_query("INSERT INTO `jazik` (`id`, `HOME`, `CONTACT`, `SEARCH`, `TOP_NEWS`, `CATEGORY`, `HOME_RADIO`, `OTHER_RADIO`, `VIDEOS`, `POPULAR_NEWS`, `POPULAR_VIDEOS`, `RSS`, `RSS_NEWS`, `TWEETS`, `TOTAL_VOTES`, `LAST_GALLERY`, `NAME`, `EMAIL`, `SUBJECT`, `MESSAGE`, `SEND_MESSAGE`, `NEXT`, `PREV`, `PUBLISHED_ON`, `VISITED`, `TIMES`, `SOURCE`, `SHARE_ON`, `LAST_ARTICLES`, `FOUND_ARTICLES`, `NEWS_TODAY`, `VISITS_TODAY`, `FLASH_NEWS`, `TAGS`, `SITEMAP`) VALUES
			(1, 'Home', 'Contact', 'Search', 'Top News', 'Category', 'Home Radio', 'Other Radio', 'Videos', 'Popular News', 'Popular Videos', 'RSS', 'RSS News', 'Tweets', 'Total Votes', 'Last Gallery', 'Name', 'E-mail', 'Subject', 'Message', 'Send Message', 'Next', 'Prev', 'Published on', 'Visited', 'Times', 'Source', 'Share on', 'Last articles from this category', 'Found articles', 'News today', 'Visits', 'Flash news', 'Tags', 'Sitemap');")!=0 &&
			
								@mysql_query("CREATE TABLE IF NOT EXISTS `kontakt` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(100) NOT NULL,
								  `email` varchar(100) NOT NULL,
								  `naslov` varchar(500) NOT NULL,
								  `poraka` varchar(1000) NOT NULL,
								  `procitana` tinyint(1) NOT NULL default '0',
								  `odgovoreno` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `korisnik` (
								  `id` int(3) NOT NULL auto_increment,
								  `username` varchar(30) NOT NULL,
								  `password` varchar(30) NOT NULL,
								  `ime` varchar(100) NOT NULL,
								  `prezime` varchar(100) NOT NULL,
								  `email` varchar(100) NOT NULL,
								  `aktivacija` tinyint(1) NOT NULL default '0',
								  `najaven` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;")!=0 &&

								@mysql_query("INSERT INTO `korisnik` (`id`, `username`, `password`, `ime`, `prezime`, `email`, `aktivacija`, `najaven`) VALUES
								(1, 'admin', 'admin', 'FirstName', 'LastName', 'admin@mail', 1, 0);")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `meteo` (
								  `id` int(3) NOT NULL auto_increment,
								  `city1` varchar(50) NOT NULL default '0',
								  `code1` varchar(15) NOT NULL default '0',
								  `city2` varchar(50) NOT NULL default '0',
								  `code2` varchar(15) NOT NULL default '0',
								  `city3` varchar(50) NOT NULL default '0',
								  `code3` varchar(15) NOT NULL default '0',
								  `city4` varchar(50) NOT NULL default '0',
								  `code4` varchar(15) NOT NULL default '0',
								  `city5` varchar(50) NOT NULL default '0',
								  `code5` varchar(15) NOT NULL default '0',
								  `city6` varchar(50) NOT NULL default '0',
								  `code6` varchar(15) NOT NULL default '0',
								  `city7` varchar(50) NOT NULL default '0',
								  `code7` varchar(15) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;")!=0 &&

								@mysql_query("INSERT INTO `meteo` (`id`, `city1`, `code1`, `city2`, `code2`, `city3`, `code3`, `city4`, `code4`, `city5`, `code5`, `city6`, `code6`, `city7`, `code7`) VALUES
								(1, 'Skopje', 'MKXX0001', 'Veles', 'MKXX0002', 'Kriva Palanka', 'MKXX0003', 'Ohrid', 'MKXX0004', 'Bitola', 'MKXX0005', 'Prilep', 'MKXX0006', 'Stip', 'MKXX0007');")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `podesuvanja` (
								      `id` int(1) NOT NULL,
									  `seo_keywords` varchar(255) NOT NULL,
									  `seo_description` varchar(255) NOT NULL,
									  `email_admin` varchar(50) NOT NULL,
									  `rss_url` varchar(255) NOT NULL,
									  `twit_user` varchar(40) NOT NULL,
									  `top_novost_modul` varchar(1) NOT NULL,
									  `twit_modul` varchar(1) NOT NULL,
									  `rss_modul` varchar(1) NOT NULL,
									  `najgledani_videa_modul` varchar(1) NOT NULL,
									  `najcitani_vesti_modul` varchar(1) NOT NULL,
									  `top_video_modul` varchar(1) NOT NULL,
									  `meteo_modul` varchar(1) NOT NULL,
									  `radio_modul` varchar(1) NOT NULL,
									  `videoteka_modul` varchar(1) NOT NULL,
									  `anketa_modul` varchar(1) NOT NULL,
									  `galerija_modul` varchar(1) NOT NULL,
									  `random_vesti_modul` varchar(1) NOT NULL,
									  `reklami_modul` varchar(1) NOT NULL,
									  `vesti_pod_statija_modul` varchar(1) NOT NULL,
									  `prebaraj_modul` varchar(1) NOT NULL,
									  `footer` varchar(500) NOT NULL,
									  `tags_modul` int(11) NOT NULL,
									  `news_flash_modul` int(1) NOT NULL
								) ENGINE=MyISAM DEFAULT CHARSET=utf8;")!=0 &&

								@mysql_query("INSERT INTO `podesuvanja` (`id`, `seo_keywords`, `seo_description`, `email_admin`, `rss_url`, `twit_user`, `top_novost_modul`, `twit_modul`, `rss_modul`, `najgledani_videa_modul`, `najcitani_vesti_modul`, `top_video_modul`, `meteo_modul`, `radio_modul`, `videoteka_modul`, `anketa_modul`, `galerija_modul`, `random_vesti_modul`, `reklami_modul`, `vesti_pod_statija_modul`, `prebaraj_modul`, `footer`, `tags_modul`, `news_flash_modul`) VALUES
								(0, 'keywords meta', 'description meta', 'mail@admin.com', 'http://localhost/cms/rss', 'zosko', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'Â©2009 - 2010 EasyCMS :: Content Menagment System', 0, 0);")!=0 &&
								@mysql_query("CREATE TABLE IF NOT EXISTS `prebaraj` (
							  `id` int(10) NOT NULL auto_increment,
							  `zbor` varchar(100) character set utf8 NOT NULL,
							  `brojac` int(10) NOT NULL,
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `radio` (
								  `id` int(2) NOT NULL auto_increment,
								  `ime` varchar(200) NOT NULL,
								  `link` varchar(100) NOT NULL,
								  `vid` varchar(50) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `reklama` (
								  `id` int(5) NOT NULL auto_increment,
								  `link` varchar(500) NOT NULL,
								  `oznaka` varchar(300) NOT NULL,
								  `polozba` varchar(50) NOT NULL,
								  `url` varchar(5000) NOT NULL,
								  `poseti` int(50) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `sekcija` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(40) character set utf8 NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `statistiki` (
								  `id` int(10) NOT NULL auto_increment,
								  `ip_adresa` varchar(20) NOT NULL,
								  `ip_adresa_anketa` varchar(20) NOT NULL,
								  `data` date NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=927 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `vest` (
								  `id` int(5) NOT NULL auto_increment,
								  `sekcija` varchar(500) character set utf8 NOT NULL,
								  `naslov` varchar(500) character set utf8 NOT NULL,
								  `voved` varchar(500) character set utf8 NOT NULL,
								  `sodrzina` varchar(5000) character set utf8 NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  `napisana_od` varchar(300) NOT NULL,
								  `datum` date NOT NULL,
								  `glavna` tinyint(1) NOT NULL default '0',
								  `click` int(5) NOT NULL default '0',
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=424 ;")!=0 &&

								@mysql_query("CREATE TABLE IF NOT EXISTS `video` (
								  `id` int(5) NOT NULL auto_increment,
								  `naslov` varchar(500) character set utf8 NOT NULL,
								  `sodrzina` varchar(500) NOT NULL,
								  `link` varchar(500) character set utf8 NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  `datum` date NOT NULL,
								  `top` tinyint(1) NOT NULL default '0',
								  `objavi` tinyint(1) NOT NULL default '0',
								  `click` int(10) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;"))
								{
									echo "<center>Easy CMS installation completed successfully!"; echo "<br /><br />
										You can now login with <b>username <font color=\"red\">admin</font></b> and <b>password <font color=\"red\">admin</font></b> on <a href=\"admin\">Admin panel</a>
										<br />or you can go on frontpage <a href=\"pocetna\">HOME</a>
										</center>";
								}
								else
								{
									echo '<center><font color="red">Database name: <b>"'.$name.'"</b> exist please create other one.</font></center>';
									@unlink($file);
								}
			}
			else
			{
				echo '<center><font color="red">Please first create your <b>"'.$name.'"</b> database.</font></center>';
				@unlink($file);
			}
		}
		else
		{
			echo '<center><font color="red">An error occured while connecting to database! Check your connection parameters.</font></center>';
			@unlink($file);
		}
	}
	else
	{
		echo '<center><font color="red">Cannot open file '.$file.'</font></center>';
		@unlink($file);
	}
}

?>
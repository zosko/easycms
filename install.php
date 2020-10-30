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
			<input type="text" name="database_password" size="30" ""/>
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
	if (fwrite($fo,$database_inf)>0) 
	{
		fclose($fo);
		if (mysqli_connect($host,$user,$pass))
		{
			 $mysqli = new mysqli($host,$user,$pass);
			if (mysqli_select_db($mysqli,$name))
			{
				if(mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `anketa` (
								  `id` int(11) NOT NULL auto_increment,
								  `prasanje` varchar(200) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;")!=0 &&

					mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `anketa_prasanja` (
								  `id` int(11) NOT NULL auto_increment,
								  `id_prasanje` varchar(200) NOT NULL,
								  `odgovor` varchar(100) NOT NULL,
								  `glasovi` int(5) NOT NULL default '1',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;")!=0 &&

					mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `galerija` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(5000) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  `naslovna` varchar(100) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `galerija_sliki` (
								  `id` int(11) NOT NULL auto_increment,
								  `id_galerija` int(11) NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `kontakt` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(500) NOT NULL,
								  `email` varchar(100) NOT NULL,
								  `naslov` varchar(500) NOT NULL,
								  `poraka` varchar(1000) NOT NULL,
								  `procitana` tinyint(1) NOT NULL default '0',
								  `odgovoreno` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `korisnik` (
								  `id` int(3) NOT NULL auto_increment,
								  `username` varchar(30) NOT NULL,
								  `password` varchar(30) NOT NULL,
								  `ime` varchar(200) NOT NULL,
								  `prezime` varchar(200) NOT NULL,
								  `email` varchar(100) NOT NULL,
								  `aktivacija` tinyint(1) NOT NULL default '0',
								  `najaven` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;")!=0 &&

								mysqli_query($mysqli,"INSERT INTO `korisnik` (`id`, `username`, `password`, `ime`, `prezime`, `email`, `aktivacija`, `najaven`) VALUES
								(1, 'admin', 'admin', 'FirstName', 'LastName', 'admin@mail', 1, 0);")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `meteo` (
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
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;")!=0 &&

								mysqli_query($mysqli,"INSERT INTO `meteo` (`id`, `city1`, `code1`, `city2`, `code2`, `city3`, `code3`, `city4`, `code4`, `city5`, `code5`, `city6`, `code6`, `city7`, `code7`) VALUES
								(1, 'Skopje', 'MKXX0001', 'Veles', 'MKXX0002', 'Kriva Palanka', 'MKXX0003', 'Ohrid', 'MKXX0004', 'Bitola', 'MKXX0005', 'Prilep', 'MKXX0006', 'Stip', 'MKXX0007');")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `podesuvanja` (
								  `id` int(1) NOT NULL,
								  `seo_keywords` varchar(255) NOT NULL,
								  `seo_description` varchar(255) NOT NULL,
								  `email_admin` varchar(50) NOT NULL,
								  `rss_url` varchar(255) NOT NULL,
								  `twit_user` varchar(40) NOT NULL,
								  `twit_pass` varchar(50) NOT NULL,
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
								  `footer` varchar(500) NOT NULL
								) ENGINE=MyISAM DEFAULT CHARSET=latin1;")!=0 &&

								mysqli_query($mysqli,"INSERT INTO `podesuvanja` (`id`, `seo_keywords`, `seo_description`, `email_admin`, `rss_url`, `twit_user`, `twit_pass`, `top_novost_modul`, `twit_modul`, `rss_modul`, `najgledani_videa_modul`, `najcitani_vesti_modul`, `top_video_modul`, `meteo_modul`, `radio_modul`, `videoteka_modul`, `anketa_modul`, `galerija_modul`, `random_vesti_modul`, `reklami_modul`, `vesti_pod_statija_modul`, `prebaraj_modul`, `footer`) VALUES
								(0, 'keywords meta', 'description meta', 'mail@admin.com', 'http://rss.news.yahoo.com/rss/world', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '©2009 - 2010 EasyCMS :: Content Menagment System');")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `radio` (
								  `id` int(2) NOT NULL auto_increment,
								  `ime` varchar(200) NOT NULL,
								  `link` varchar(100) NOT NULL,
								  `vid` varchar(50) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `reklama` (
								  `id` int(5) NOT NULL auto_increment,
								  `link` varchar(500) NOT NULL,
								  `oznaka` varchar(300) NOT NULL,
								  `polozba` varchar(50) NOT NULL,
								  `url` varchar(5000) NOT NULL,
								  `poseti` int(50) NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `sekcija` (
								  `id` int(11) NOT NULL auto_increment,
								  `ime` varchar(40) character set utf8 NOT NULL,
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `statistiki` (
								  `id` int(5) NOT NULL auto_increment,
								  `ip_adresa` varchar(20) NOT NULL,
								  `ip_adresa_anketa` varchar(14) NOT NULL,
								  `data` int(11) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=927 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `vest` (
								  `id` int(5) NOT NULL auto_increment,
								  `sekcija` varchar(500) character set utf8 NOT NULL,
								  `naslov` varchar(500) character set utf8 NOT NULL,
								  `voved` varchar(500) character set utf8 NOT NULL,
								  `sodrzina` varchar(5000) character set utf8 NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  `golema_slika` varchar(500) NOT NULL,
								  `napisana_od` varchar(300) NOT NULL,
								  `datum` date NOT NULL,
								  `glavna` tinyint(1) NOT NULL default '0',
								  `click` int(5) NOT NULL default '0',
								  `objavi` tinyint(1) NOT NULL default '0',
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=424 ;")!=0 &&

								mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `video` (
								  `id` int(5) NOT NULL auto_increment,
								  `naslov` varchar(500) character set utf8 NOT NULL,
								  `sodrzina` varchar(500) NOT NULL,
								  `link` varchar(500) character set utf8 NOT NULL,
								  `slika` varchar(500) NOT NULL,
								  `top` tinyint(1) NOT NULL default '0',
								  `objavi` tinyint(1) NOT NULL default '0',
								  `click` int(10) NOT NULL,
								  PRIMARY KEY  (`id`)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;"))
								{
									echo "<center>Easy CMS installation completed successfully!"; echo "<br /><br />
										You can now login with <b>username <font color=\"red\">admin</font></b> and <b>password <font color=\"red\">admin</font></b> on <a href=\"admin\">Admin panel</a>
										<br />or you can go on frontpage <a href=\"pocetna\">HOME</a>
										</center>";
								}
								else
								{
									echo '<center><font color="red">Database name: <b>"'.$name.'"</b> exist please create other one.</font></center>';
									unlink($file);
								}
			}
			else
			{
				echo '<center><font color="red">Please first create your <b>"'.$name.'"</b> database.</font></center>';
				unlink($file);
			}
		}
		else
		{
			echo '<center><font color="red">An error occured while connecting to database! Check your connection parameters.</font></center>';
			unlink($file);
		}
	}
	else
	{
		echo '<center><font color="red">Cannot open file '.$file.'</font></center>';
		unlink($file);
	}
}

?>
<?php
session_start();
if (!isset($_SESSION['logiran_user']) || $_SESSION['logiran_user'] != true || time() - $_SESSION['vreme'] > 1800) 
{
	header('Location: admin-login');
	exit;
}
require_once('../includes/konekcija/baza_konektor.php');

//ЗА НЕПРОЧИТАНИ ПОРАКИ ОД КОНТАКТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM kontakt WHERE procitana='0' ");
$neprocitani_poraki = mysqli_num_rows($izlez);

//НА НАЈАВЕН КОРИСНИК ДОДАВА 1 ВО БАЗА ДЕКА Е НАЈВЕН
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE korisnik SET najaven='1' WHERE username='".$_SESSION['user']."'");

//КОГА СЕ ПИШУВА ВЕСТ ОД КОГО Е ДА ИМА
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM korisnik WHERE username='".$_SESSION['user']."'");
$row = $konektor->fetchArray($izlez);
$napisana_od = $row['ime'].' '.$row['prezime'];

//ПРИКАЖУВА СИТЕ НАЈАВЕНИ КОРИСНИЦИ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM korisnik WHERE najaven='1'");
$user_logiran = "";
while ($row = $konektor->fetchArray($izlez))
{
	$korisnici = $row['ime'].' '.$row['prezime'];
	$user_logiran .= $korisnici.'<br />';
}
//ФУНКЦИЈА ЗА ПРАЌАЊЕ ПОРАКА
function sendHTML($message,$from,$to,$subject)
{
	$headers = "From: $from\r\n"; 
	$headers .= "MIME-Version: 1.0\r\n";
    $boundary = uniqid("HTMLEMAIL"); 
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode(strip_tags($message))); 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
    $headers .= chunk_split(base64_encode($message)); 
     mail($to,$subject,"",$headers);
}

//СТРАНИЧЕЊЕ
$max = 20;
$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
$limits = ($strana - 1) * $max;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin menu</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/all.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/paginator.css" type="text/css" />
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.ui.draggable.js" type="text/javascript"></script>    
    <script src="js/jquery.alerts.js" type="text/javascript"></script>
    <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="main">
	<div id="header">
		<ul id="top-navigation">
			<li class="active"><span><span>Home</span></span></li>
			<li><span><span><a href="admin-vest">News</a></span></span></li>
			<li><span><span><a href="admin-video">Video</a></span></span></li>
			<li><span><span><a href="admin-galerija">Gallery</a></span></span></li>
			<li><span><span><a href="admin-reklami">Banners</a></span></span></li>
			<li><span><span><a href="admin-korisnici">Users</a></span></span></li>
			<li><span><span><a href="admin-radio">Radio</a></span></span></li>
			<li><span><span><a href="admin-anketa">Poll</a></span></span></li>
			<li><span><span><a href="admin-izlez">Logout</a></span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<h3>Menu</h3>
			<ul class="nav">
			<?php 
				if($neprocitani_poraki > 0)
				{
					echo '<li><a href="admin-sandace">MailBox <font color="red"><blink>('.$neprocitani_poraki.')</blink></font></a></li>
							<li><a href="admin-statistika">Statistic</a></li>
							<li class="last"><a href="admin-podesuvanja">Settings</a></li>
						</ul>
						<a href="admin-sekcii" class="link">Category</a>
						<b>Logged:</b><br />'.$user_logiran;
				}
				else
				{
					echo '<li><a href="admin-sandace">MailBox</a></li>
							<li><a href="admin-statistika">Statistic</a></li>
							<li class="last"><a href="admin-podesuvanja">Settings</a></li>
						</ul>
						<a href="admin-sekcii" class="link">Category</a>
						<b>Logged:</b><br />'.$user_logiran;
				}
				?>
		</div>
		<div id="center-column">
			<?php
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'sekcii')
				{
					echo '<form method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2" colspan="2">Add category:</td><td colspan="2" class="first style2"><input type="text" id="ime" name="ime" /><input type="submit" name="prati_sekcija" id="prati_sekcija" value="Add Category" /></td></tr>
								</table>
							</div>
							<div class="table">
								<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
								<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
								<table class="listing" cellpadding="0" cellspacing="0">
									<th class="first">Category</th>
									<th>Publish</th>
									<th>Edit</th>
									<th class="last">Delete</th>';
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM sekcija ORDER BY ID DESC");
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr><td class="first style2">'.$row['ime'].'</td>
							
							<td><a href="admin-sekcii-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
							<td><a href="admin-sekcii-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
							<td><a href="admin-sekcii-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td class="first style2">'.$row['ime'].'</td>
							
							<td><a href="admin-sekcii-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
							<td><a href="admin-sekcii-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
							<td><a href="admin-sekcii-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table></div></form>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'promeni_sekcija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM sekcija WHERE id='".$_GET['id']."'"); 
					$row = $konektor->fetchArray($izlez);
					echo '<form method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr>
										<td class="first style2">Change name of category</td>
										<td class="first style2"><input type="text" name="sekcija_promeni" id="sekcija_promeni" value="'.$row['ime'].'" />
										<input type="submit" name="sekcija_promeni_kopce" id="sekcija_promeni_kopce" value="Save"/></td>
									</tr>
								</table>
							<input type="hidden" name="sekcija_promeni_kopce_id" value="'.$_GET['id'].'"/>
							</div>
						</form>';
				}
				if(isset($_POST['sekcija_promeni_kopce']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE sekcija SET ime='".$_POST['sekcija_promeni']."' WHERE id='".$_POST['sekcija_promeni_kopce_id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-pocetna";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['prati_sekcija']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO sekcija(ime) VALUES ('".$_POST['ime']."')"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-pocetna";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'brisi_sekcija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM sekcija WHERE id='".$_GET['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-pocetna";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'objavi_sekcija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE sekcija SET objavi='1' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-pocetna";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'neobjavi_sekcija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE sekcija SET objavi='0' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-pocetna";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
			?>
			<?php
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'sandace')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM kontakt ORDER BY id DESC LIMIT ".$limits.",$max");

				$res = $konektor->query("SELECT COUNT(id) FROM kontakt");	
				$totalres = sizeof($res->fetch_array(MYSQLI_NUM));
				$totalpages = ceil($totalres / $max);
				
				echo '<div id="tnt_pagination">';
				echo '<a href="admin.php?akcija=sandace&strana='.($strana - 1).'">Prev</a>';
				for($i=1;$i<=$totalpages;$i++)
				{
					echo '<a href="admin.php?akcija=sandace&strana='.$i.'">'.$i.'</a>';
				}
				echo '<a href="admin.php?akcija=sandace&strana='.($strana + 1).'">Next</a>';
				echo '</div>';
		
				echo '<div class="table">
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first" width="70">Name</th>
								<th>E-mail</th>
								<th width="100">Subtitle</th>
								<th width="10">Open</th>
								<th width="10">Answered</th>
								<th width="10" class="last">Delete</th>
							</tr>';
				while ($row = $konektor->fetchArray($izlez))
				{
					echo'<tr>
						<td class="first style2"><a href="admin-poraka-procitaj-'.$row['id'].'.html">'.$row['ime'].'</a></td>
						<td>'.$row['email'].'</td>
						<td><a href="admin-poraka-procitaj-'.$row['id'].'.html">'.$row['naslov'].'</a></td>';
					if($row['procitana'] == 0)
					{
						echo '<td><img src="sliki/hr.gif" width="16" height="16" alt="" /></td>';
					}
					if($row['procitana'] == 1)
					{
						echo '<td><img src="sliki/publish_g.png" width="16" height="16" alt="" /></td>';
					}
					if($row['odgovoreno'] == 0)
					{
						echo '<td><img src="sliki/hr.gif" width="16" height="16" alt="" /></td>';
					}
					if($row['odgovoreno'] == 1)
					{
						echo '<td><img src="sliki/publish_g.png" width="16" height="16" alt="" /></td>';
					}
					echo	'<td class="last"><a href="admin-poraka-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
				}
				echo '</tr></table></div>';
			}
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'procitaj_poraka')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("UPDATE kontakt SET procitana='1' WHERE id='".$_GET['id']."'"); 
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM kontakt WHERE id='".$_GET['id']."'");
				$row = $konektor->fetchArray($izlez);
				echo '<form method="post" action="">
						<div class="table">
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr><td class="first style1" width="100">Name</td><td>'.$row['ime'].'</td></tr>
							<tr><td class="first style1">E-mail</td><td>'.$row['email'].'</td></tr>
							<tr><td class="first style1">Subtitle</td><td>'.$row['naslov'].'</td></tr>
							<tr><td class="first style1">Message</td></tr>
							<tr><td class="first style2" colspan="2">'.$row['poraka'].'</td></tr>
						</table>
						<input type="submit" name="odgovori_poraka" id="odgovori_poraka" value="Одговори" />
						<input type="hidden" name="from_poraka" id="from_poraka" value="'.$row['email'].'" />
						<input type="hidden" name="naslov_poraka" id="naslov_poraka" value="'.$row['naslov'].'" />
						<input type="hidden" name="id_poraka" id="id_poraka" value="'.$_GET['id'].'" />
					</form>';
			}
			if(isset($_POST['odgovori_poraka']))
			{
				$to      = $_POST['from_poraka'];
				$id_poraka      = $_POST['id_poraka'];
				$subject = 'Re:'.$_POST['naslov_poraka'];
				echo '<form method="post" action="">
						<div class="table">
							<table class="listing" cellpadding="0" cellspacing="0">
								<tr><td class="first style1" colspan="2"><textarea rows="5" cols="110" name="mail_prati" id="mail_prati"></textarea></td></tr>
							</table>
						<input type="submit" name="prati_odgovori_poraka" id="prati_odgovori_poraka" value="Reply" />
						<input type="hidden" name="za_poraka" id="za_poraka" value="'.$to.'" />
						<input type="hidden" name="naslov_poraka" id="naslov_poraka" value="'.$subject.'" />
						<input type="hidden" name="id_poraka" id="id_poraka" value="'.$id_poraka.'" />
						</div>
					</form>';
			}
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'poraka_izbrisi')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("DELETE FROM kontakt WHERE id='".$_GET['id']."'");
				if($izlez)
				{
					echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
				}
				else
				{
					echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
				}
			}
			if(isset($_POST['prati_odgovori_poraka']))
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM Podesuvanja");
				$row = $konektor->fetchArray($izlez);
				$email_admin = $row['email_admin'];
			
				$konektor = new baza_konektor();
				$izlez = $konektor->query("UPDATE kontakt SET odgovoreno='1' WHERE id='".$_POST['id_poraka']."'"); 
				$from = $email_admin;
				$to      = $_POST['za_poraka'];
				$subject = 'Re:'.$_POST['naslov_poraka'];
				
				echo "<script type=\"text/javascript\">jAlert('success', 'Message was sent.', 'Success');</script>";
				//Одкоментирај го следното за да се праќа пораката
				//sendHTML($contents,$from,$to,$subject);
			}
			?>
			<?php
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'statistika')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT COUNT(id) AS pregledi FROM statistiki WHERE data='".date("Ydm")."'");
				$row = $konektor->fetchArray($izlez);
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT DISTINCT(ip_adresa) FROM statistiki WHERE data='".date("Ydm")."'");
				$rowCheck = mysqli_num_rows($izlez);
				echo '<div class="table">
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first" width="140"></th>
								<th lass="last"></th>
							</tr>
							<tr>
								<td>Today visits: </td>
								<td>'.$row['pregledi'].'</td>
							</tr>
							<tr>
								<td>Today unique visits: </td>
								<td>'.$rowCheck.'</td>
							</tr>
							</table></div>';
			}
			?>
			<?php
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'podesuvanja')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM podesuvanja WHERE id=0");
				$row = $konektor->fetchArray($izlez);
				echo '<form method="post" action=""><div class="table">
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first" width="140"></th>
								<th lass="last"></th>
							</tr>
							<tr>
								<td>Footer text</td>
								<td><input value="'.$row['footer'].'" type="text" id="footerz" name="footerz" size="70"/></td>
							</tr>
							<tr>
								<td>Keywords</td>
								<td><input value="'.$row['seo_keywords'].'" type="text" id="seo_keywords" name="seo_keywords" size="70"/></td>
							</tr>
							<tr>
								<td>Description</td>
								<td><input value="'.$row['seo_description'].'" type="text" id="seo_description" name="seo_description" size="70" /></td>
							</tr>
							<tr>
								<td>Admin e-mail</td>
								<td><input value="'.$row['email_admin'].'" type="text" id="email_admin" name="email_admin" size="70"/></td>
							</tr>
							<tr>
								<td>RSS source</td>
								<td><input value="'.$row['rss_url'].'" type="text" id="rss_url" name="rss_url" size="70"/></td>
							</tr>
						</table></div>
						<div class="table">
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first" width="140"></th>
								<th lass="last"></th>
							</tr>
							<tr>
								<td>Twitter user</td>
								<td><input value="'.$row['twit_user'].'" type="text" id="twit_user" name="twit_user" size="70"/></td>
							</tr>
							<tr>
								<td>Twitter password</td>
								<td><input value="'.$row['twit_pass'].'" type="text" id="twit_pass" name="twit_pass" size="70"/></td>
							</tr>
						</table></div>
						
						<div class="table">
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first" width="140">Module</th>
								<th>Active</th>
								<th class="last">Activated</th>
							</tr>
							<tr>
								<td>Twitter (not work)</td>
								<td>
									<select name="twit_modul">
										<option value="'.$row['twit_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['twit_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Poll</td>
								<td>
									<select name="anketa_modul">
										<option value="'.$row['anketa_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['anketa_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Gallery</td>
								<td>
									<select name="galerija_modul">
										<option value="'.$row['galerija_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['galerija_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>RSS news</td>
								<td>
									<select name="rss_modul">
										<option value="'.$row['rss_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['rss_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>TOP news</td>
								<td>
									<select name="top_novost_modul">
										<option value="'.$row['top_novost_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['top_novost_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>TOP video</td>
								<td>
									<select name="top_video_modul">
										<option value="'.$row['top_video_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['top_video_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Videos</td>
								<td>
									<select name="videoteka_modul">
										<option value="'.$row['videoteka_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['videoteka_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td><a href="admin-meteo"><b>Weather (not work)</b></a></td>
								<td>
									<select name="meteo_modul">
										<option value="'.$row['meteo_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['meteo_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Radio</td>
								<td>
									<select name="radio_modul">
										<option value="'.$row['radio_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['radio_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Most visited news</td>
								<td>
									<select name="najcitani_vesti_modul">
										<option value="'.$row['najcitani_vesti_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['najcitani_vesti_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Most visited video</td>
								<td>
									<select name="najgledani_videa_modul">
										<option value="'.$row['najgledani_videa_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['najgledani_videa_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Random news</td>
								<td>
									<select name="random_vesti_modul">
										<option value="'.$row['random_vesti_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['random_vesti_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Banners</td>
								<td>
									<select name="reklami_modul">
										<option value="'.$row['reklami_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['reklami_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Articles below content</td>
								<td>
									<select name="vesti_pod_statija_modul">
										<option value="'.$row['vesti_pod_statija_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['vesti_pod_statija_modul'].'.gif" /></td>
							</tr>
							<tr>
								<td>Search</td>
								<td>
									<select name="prebaraj_modul">
										<option value="'.$row['prebaraj_modul'].'"></option>
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</td>
								<td><img src="sliki/'.$row['prebaraj_modul'].'.gif" /></td>
							</tr>
						</table>
						<input type="submit" name="prati_podesuvanja" id="prati_podesuvanja" value="Save" />
						</div>
						</form>';
			}
			if(isset($_POST['prati_podesuvanja']))
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("UPDATE podesuvanja SET seo_keywords='".$_POST['seo_keywords']."',seo_description='".$_POST['seo_description']."',email_admin='".$_POST['email_admin']."',rss_url='".$_POST['rss_url']."',twit_user='".$_POST['twit_user']."',twit_pass='".$_POST['twit_pass']."',top_novost_modul='".$_POST['top_novost_modul']."',twit_modul='".$_POST['twit_modul']."',rss_modul='".$_POST['rss_modul']."',najgledani_videa_modul='".$_POST['najgledani_videa_modul']."',najcitani_vesti_modul='".$_POST['najcitani_vesti_modul']."',top_video_modul='".$_POST['top_video_modul']."',meteo_modul='".$_POST['meteo_modul']."',radio_modul='".$_POST['radio_modul']."',videoteka_modul='".$_POST['videoteka_modul']."',anketa_modul='".$_POST['anketa_modul']."',galerija_modul='".$_POST['galerija_modul']."',random_vesti_modul='".$_POST['random_vesti_modul']."',reklami_modul='".$_POST['reklami_modul']."',vesti_pod_statija_modul='".$_POST['vesti_pod_statija_modul']."',prebaraj_modul='".$_POST['prebaraj_modul']."',footer='".$_POST['footerz']."' WHERE id=0"); 
				if($izlez)
				{
					echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
					echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-podesuvanja";</script>';
				}
				else
				{
					echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
				}
			}
			?>
			<?php
			if(isset($_GET['akcija']) && $_GET['akcija'] == 'meteo')
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("SELECT * FROM meteo");
				$row = $konektor->fetchArray($izlez);
				echo	'<form method="post" action="">
				<div class="table" >
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<table class="listing" cellpadding="0" cellspacing="0">
							<tr>
								<th class="first">City</th>
								<th lass="last">Code</th>
							</tr>
							<tr>
								<td><input value="'.$row['city1'].'" type="text" id="city1" name="city1" /></td>
								<td><input value="'.$row['code1'].'" type="text" id="code1" name="code1" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city2'].'" type="text" id="city1" name="city2" /></td>
								<td><input value="'.$row['code2'].'" type="text" id="code1" name="code2" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city3'].'" type="text" id="city1" name="city3" /></td>
								<td><input value="'.$row['code3'].'" type="text" id="code1" name="code3" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city4'].'" type="text" id="city1" name="city4" /></td>
								<td><input value="'.$row['code4'].'" type="text" id="code1" name="code4" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city5'].'" type="text" id="city1" name="city5" /></td>
								<td><input value="'.$row['code5'].'" type="text" id="code1" name="code5" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city6'].'" type="text" id="city1" name="city6" /></td>
								<td><input value="'.$row['code6'].'" type="text" id="code1" name="code6" /></td>
							</tr>
							<tr>
								<td><input value="'.$row['city7'].'" type="text" id="city1" name="city7" /></td>
								<td><input value="'.$row['code7'].'" type="text" id="code1" name="code7" /></td>
							</tr>
						</table>
						<input type="submit" name="prati_meteo" id="prati_meteo" value="Save" />
						</div>
						</form>';
			}
			if(isset($_POST['prati_meteo']))
			{
				$konektor = new baza_konektor();
				$izlez = $konektor->query("UPDATE meteo SET city1='".$_POST['city1']."',code1='".$_POST['code1']."',city2='".$_POST['city2']."',code2='".$_POST['code2']."',city3='".$_POST['city3']."',code3='".$_POST['code3']."',city4='".$_POST['city4']."',code4='".$_POST['code4']."',city5='".$_POST['city5']."',code5='".$_POST['code5']."',city6='".$_POST['city6']."',code6='".$_POST['code6']."',city7='".$_POST['city7']."',code7='".$_POST['code7']."' WHERE id=1"); 
				if($izlez)
				{
					echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
					echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-podesuvanja";</script>';
				}
				else
				{
					echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
				}
				
			}
			?>
		</div>
	</div>
	<div id="footer"><center><br />&copy; 2009-<?php echo date('Y');?></center></div>
</div>


</body>
</html>

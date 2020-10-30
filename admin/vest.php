<?php
session_start();
if (!isset($_SESSION['logiran_user']) || $_SESSION['logiran_user'] != true || time() - $_SESSION['vreme'] > 1800) 
{
	header('Location: admin-login');
	exit;
}
require_once('../includes/konekcija/baza_konektor.php');
//ФУНКЦИЈА ЗА ПРОВЕРУВАЊЕ ЕКСТЕНЗИЈА
function getExtension($str) 
{
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}
//КОГА СЕ ПИШУВА ВЕСТ ОД КОГО Е ДА ИМА
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM korisnik WHERE username='".$_SESSION['user']."'");
$row = $konektor->fetchArray($izlez);
$napisana_od = $row['ime'].' '.$row['prezime'];

//СТРАНИЧЕЊЕ
$max = 20;
$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
$limits = ($strana - 1) * $max;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - News</title>
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
			<li><span><span><a href="admin-pocetna">Home</a></span></span></li>
			<li class="active"><span><span>News</span></span></li>
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
				<li><a href="admin-vest-dodadi">New article</a></li>
				<li class="last"><a href="admin-vest-lista">Edit article</a></li>
			</ul>
		</div>
		<div id="center-column">
<?php
if(isset($_GET['akcija']) && $_GET['akcija'] == 'dodadi_vest')
{
	echo '<form enctype="multipart/form-data" method="post" action="">
		<div class="table">
			<table class="listing" cellpadding="0" cellspacing="0">
				<tr><td class="first style2">Category:</td><td class="first style2">
					<select name="sekcija">
						<option value="">Choose category</option>';
							$konektor = new baza_konektor();
							$izlez = $konektor->query("SELECT * FROM sekcija ORDER BY ID DESC");
							while ($row = $konektor->fetchArray($izlez))
							{
								echo '<option value="'.$row['id'].'">'.$row['ime'].'</option>';
							}
			echo'</select></td></tr>
				<tr><td class="first style2" width="100">Author:</td><td class="first style2">'.$napisana_od.'</td></tr>
				<tr><td class="first style2">Title:</td><td class="first style2"><input type="text" id="naslov" name="naslov" size="50"/></td></tr>
				<tr><td class="first style2">Publish now:</td><td class="first style2"><select name="objavi_vednas_vest"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
				<tr><td class="first style2">Top news:</td><td class="first style2"><select name="top_tema"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
				<tr><td class="first style2">Small picture:</td><td class="first style2"><input type="file" name="image" id="image" /></td></tr>
				<tr><td class="first style2">Big picture:</td><td class="first style2"><input type="file" name="image1" id="image1" /></td></tr>
				<tr><td class="first style2">Intro text:</td></tr>
				<tr><td colspan="2"><textarea wrap="hard" name="voved" id="voved" rows="5" cols="110" ></textarea></td></tr>
				<tr><td colspan="2">Content:</td></tr>
				<tr><td colspan="2"><textarea wrap="hard" name="sodrzina" id="sodrzina" rows="13" cols="110" ></textarea></td></tr>
			</table>
			<input type="hidden" name="napisana_od" id="napisana_od" value="'.$napisana_od.'" />
			<input type="hidden" name="datum" id="datum" value="'.date("Y-m-d").'" />
			<input type="submit" name="prati_vest" id="prati_vest" value="Add new" />
		</form></div>';
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'editiraj_vest')
{
	echo '<form method="post" action="vest.php?akcija=prikazi_vesti">
			<div class="table">
			<table class="listing" cellpadding="0" cellspacing="0">
				<tr>
					<td width="70" class="first style2">Category:</td>
					<td class="first style2">
					<select name="sekcija_lista" onChange="this.form.submit();">
						<option value="">Choose</option>';
						$konektor = new baza_konektor();
						$izlez = $konektor->query("SELECT * FROM sekcija ORDER BY ID DESC");
						while ($row = $konektor->fetchArray($izlez))
						{
							echo '<option value="'.$row['id'].'">'.$row['ime'].'</option>';
						}
					echo '</select>
		<input type="hidden" name="prikazi_vesti" id="prikazi_vesti" value="Show article" />
		</table></form></div>';
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'prikazi_vesti')
{
	$sekcijaz = "";
if($_POST['sekcija_lista'] == "")
	$sekcijaz = isset($_GET['sekcija']) ? $_GET['sekcija'] : "";
if($sekcijaz == "")
	$sekcijaz = $_POST['sekcija_lista'];

				$konektor = new baza_konektor();
				$res = $konektor->query("SELECT COUNT(id) FROM vest WHERE sekcija='".$sekcijaz."'");	
				$totalres = sizeof($res->fetch_array(MYSQLI_NUM));

				$totalpages = ceil($totalres / $max);

				echo '<div id="tnt_pagination">';
				echo '<a href="vest.php?akcija=prikazi_vesti&sekcija='.$sekcijaz.'&strana='.($strana - 1).'">Prev</a>';
				for($i=1;$i<=$totalpages;$i++)
				{
					echo '<a href="vest.php?akcija=prikazi_vesti&sekcija='.$sekcijaz.'&strana='.$i.'">'.$i.'</a>';
				}
				echo '<a href="vest.php?akcija=prikazi_vesti&sekcija='.$sekcijaz.'&strana='.($strana + 1).'">Next</a>';
				echo '</div>';	

	echo '<div class="table">
		<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
		<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
		<table class="listing" cellpadding="0" cellspacing="0">
		<th class="first" width="177">Title</th>
		<th width="70">Edit</th>
		<th width="70">Publish</th>
		<th width="70" class="last">Delete</th>
		';
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE sekcija='".$sekcijaz."' ORDER BY ID DESC LIMIT ".$limits.",$max");
	while ($row = $konektor->fetchArray($izlez))
	{
		$objavi = $row['objavi'];
		if($objavi == 0)
		{
			echo '<tr>
					<td class="first style2">'.$row['naslov'].'</td>
					<td><a href="admin-vest-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
					<td><a href="admin-vest-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
					<td><a href="admin-vest-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
				</tr>';
		}
		if($objavi == 1)
		{
			echo '<tr>
					<td class="first style2">'.$row['naslov'].'</td>
					<td><a href="admin-vest-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
					<td><a href="admin-vest-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
					<td><a href="admin-vest-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
				</tr>';
		}
	}
	echo '</table></div>';
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'promeni_vest')
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM vest WHERE id='".$_GET['id']."' ORDER BY ID DESC");
	$row = $konektor->fetchArray($izlez);
	echo '<div class="table">
		<form method="post" action="">';
	echo '<table class="listing" cellpadding="0" cellspacing="0">
			<tr><td class="first style2">Title:</td><td class="first style2"><input value="'.$row['naslov'].'" type="text" id="naslov" name="naslov" size="40" /></td></tr>
			<tr><td class="first style2" colspan="2">Small picture:</td></tr>
			<tr><td colspan="2"><img src="../images/vest/'.$row['slika'].'" /></td></tr>
			<tr><td class="first style2" colspan="2">Intro text:</td></tr>
			<tr><td colspan="2"><textarea wrap="hard" name="voved" id="voved" rows="10" cols="110" >'.$row['voved'].'</textarea></td></tr>
			<tr><td class="first style2" colspan="2">Big picture:</td></tr>
			<tr><td colspan="2"><img src="../images/vest/'.$row['golema_slika'].'" width="400" height="300"/></td></tr>
			<tr><td class="first style2" colspan="2">Content:</td></tr>
			<tr><td colspan="2"><textarea wrap="hard" name="sodrzina" id="sodrzina" rows="10" cols="110" >'.$row['sodrzina'].'</textarea></td></tr>
			</table>
			<input type="submit" name="smeni_vest" id="smeni_vest" value="Save article" />
			<input type="hidden" name="id_vest" id="id_vest" value="'.$_GET['id'].'" />
			</form></div>';
}
if(isset($_POST['prati_vest']))
{
	$momentalna_datoteka = getcwd();
	$pom = "/../images/vest";
	$zz = "/";
	$datoteka_golemi_sliki = $momentalna_datoteka.$pom.$zz;
	$datoteka_mali_sliki = $momentalna_datoteka.$pom.$zz;
	$sirina = 300; // ЗА СЛИКАТА КОЛКАВА ДИМЕНЗИЈА ДА ЈА ПРАВИ
	$golema_slika = $_FILES['image']['name'];
	$filename = stripslashes($_FILES['image']['name']);
	$extension = getExtension($filename);
	$extension = strtolower($extension);
	if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "bmp") && ($extension != "png") && ($extension != "gif"))
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'Unknown extension.', 'Error');</script> ";
	}
	else
	{
		$broj = rand(0,100000);
		$ime=str_replace(" ","_",$filename);
		$ime = strtolower($ime);
		$ime = $broj."_".$ime;
		$ime_golema = "golema_".$ime;
		$bravo = move_uploaded_file($_FILES['image']['tmp_name'], $datoteka_golemi_sliki.$ime);
		$bravo1 = move_uploaded_file($_FILES['image1']['tmp_name'], $datoteka_golemi_sliki.$ime_golema);
		//НАМАЛУВАЊЕ НА СЛИКАТА ИЛИ ЗГОЛЕМУВАЊЕ
		if(preg_match('/[.](jpg)$/', $ime)) {$image = imagecreatefromjpeg($datoteka_golemi_sliki . $ime);} 
		else if (preg_match('/[.](jpeg)$/', $ime)) {$image = imagecreatefromjpeg($datoteka_golemi_sliki . $ime);} 
		else if (preg_match('/[.](bmp)$/', $ime)) {$image = imagecreatefromjpeg($datoteka_golemi_sliki . $ime);} 
		else if (preg_match('/[.](gif)$/', $ime)) {$image = imagecreatefromgif($datoteka_golemi_sliki . $ime);} 
		else if (preg_match('/[.](png)$/', $ime)) {$image = imagecreatefrompng($datoteka_golemi_sliki . $ime);}
		$ox = imagesx($image);
		$oy = imagesy($image);
		$nx = $sirina;
		$ny = floor($oy * ($sirina / $ox));
		$nm = imagecreatetruecolor($nx, $ny);
		imagecopyresized($nm, $image, 0,0,0,0,$nx,$ny,$ox,$oy);
		imagejpeg($nm, $datoteka_mali_sliki . $ime);
		if ($bravo && $bravo1) 
		{
			echo 'Успешно качена слика<br />';
		}
	}
	$konektor = new baza_konektor();
	$izlez = $konektor->query("INSERT INTO vest(sekcija,naslov,voved,sodrzina,napisana_od,datum,objavi,glavna,slika,golema_slika) VALUES ('".$_POST['sekcija']."','".$_POST['naslov']."','".$_POST['voved']."','".$_POST['sodrzina']."','".$_POST['napisana_od']."','".$_POST['datum']."','".$_POST['objavi_vednas_vest']."','".$_POST['top_tema']."','".$ime."','".$ime_golema."')"); 
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-vest";</script>';
	}
	else
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
	}
}
if(isset($_POST['smeni_vest']))
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("UPDATE vest SET naslov='".$_POST['naslov']."', voved='".$_POST['voved']."', sodrzina='".$_POST['sodrzina']."' WHERE id='".$_POST['id_vest']."'"); 
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-vest";</script>';
	}
	else
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
	}
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'brisi_vest')
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("DELETE FROM vest WHERE id='".$_GET['id']."'");
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'Successfully deleted.', 'Success');</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
	}
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'objavi_vest')
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("UPDATE vest SET objavi='1' WHERE id='".$_GET['id']."'"); 
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
	}
	else
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
	}
}
if(isset($_GET['akcija']) && $_GET['akcija'] == 'neobjavi_vest')
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("UPDATE vest SET objavi='0' WHERE id='".$_GET['id']."'"); 
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'Successfully unpublish.', 'Success');</script>";
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

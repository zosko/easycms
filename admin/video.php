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

//СТРАНИЧЕЊЕ
$max = 20;
$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
$limits = ($strana - 1) * $max;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - Video</title>
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
			<li><span><span><a href="admin-vest">News</a></span></span></li>
			<li class="active"><span><span>Video</span></span></li>
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
				<li><a href="admin-video-dodadi">Add video</a></li>
				<li class="last"><a href="admin-video-lista">Edit video</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'dodadi_video')
				{
					echo '<form enctype="multipart/form-data" method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td width="70" class="first style2">Link:</td><td class="first style1">http://www.youtube.com/watch?v=<font color="red">EuB8PaPauAg</font><br /><input size="50" type="text" name="link" id="link" /></td></tr>
									<tr><td class="first style2">Picture:</td><td class="first style1"><input size="38" type="file" name="image" id="image" /></td></tr>
									<tr><td class="first style2">Title:</td><td class="first style1"><input maxlength="25" size="50" type="text" name="naslov" id="naslov" /></td></tr>
									<tr><td class="first style2">Content:</td><td class="first style1"><textarea rows="4" cols="55" name="sodrzina_video" id="sodrzina_video" ></textarea></td></tr>
									<tr><td class="first style2">TOP video:</td><td class="first style1"><select name="top_video"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
									<tr><td class="first style2">Publish now:</td><td class="first style1"><select name="objavi_vednas"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
								</table>
								<input type="submit" name="dodadi_videoto" id="dodadi_videoto" value="Add video" />
							</div>
						</form>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'promeni_video')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM video WHERE id='".$_GET['id']."' ORDER BY ID DESC");
					$row = $konektor->fetchArray($izlez);
					echo '<form enctype="multipart/form-data" method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td width="70" class="first style2">Link:</td><td class="first style1">http://www.youtube.com/watch?v=<font color="red">EuB8PaPauAg</font><input value="'.$row['link'].'" size="50" type="text" name="link" id="link" /></td></tr>
									<tr><td class="first style2">Picture:</td><td class="first style1"><img src="../images/video/'.$row['slika'].'" /></td></tr>
									<tr><td class="first style2">Title:</td><td class="first style1"><input value="'.$row['naslov'].'" maxlength="25" size="50" type="text" name="naslov" id="naslov" /></td></tr>
									<tr><td class="first style2">Content:</td><td class="first style1"><textarea rows="4" cols="55" name="sodrzina_video" id="sodrzina_video" >'.$row['sodrzina'].'</textarea></td></tr>
								</table>
								<input type="submit" name="promeni_videoto" id="promeni_videoto" value="Save" />
								<input type="hidden" name="id_video" id="id_video" value="'.$_GET['id'].'" />
							</div>
						</form>
							<object width="280" height="220">
							<embed src="'.$row['link'].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="400" />
							</object><br />';
				}
				if(isset($_POST['dodadi_videoto']))
				{
					$momentalna_datoteka = getcwd();
					$pom = "/../images/video";
					$zz = "/";
					$datoteka_golemi_sliki = $momentalna_datoteka.$pom.$zz;
					$datoteka_mali_sliki = $momentalna_datoteka.$pom.$zz;
					$sirina = 150; // ЗА СЛИКАТА КОЛКАВА ДИМЕНЗИЈА ДА ЈА ПРАВИ
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
						$bravo = move_uploaded_file($_FILES['image']['tmp_name'], $datoteka_golemi_sliki.$ime);
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
						if ($bravo) 
						{
							echo 'Успешно качена слика<br />';
						}
					}
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO video(link,naslov,sodrzina,top,objavi,slika,click) VALUES ('".$_POST['link']."','".$_POST['naslov']."','".$_POST['sodrzina_video']."','".$_POST['top_video']."','".$_POST['objavi_vednas']."','".$ime."','0')");
					print("INSERT INTO video(link,naslov,sodrzina,top,objavi,slika,click) VALUES ('".$_POST['link']."','".$_POST['naslov']."','".$_POST['sodrzina_video']."','".$_POST['top_video']."','".$_POST['objavi_vednas']."','".$ime."','0')");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-video";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";

					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'editiraj_video')
				{
				$konektor = new baza_konektor();

				$res = $konektor->query("SELECT COUNT(id) FROM video");	
				$totalres = sizeof($res->fetch_array(MYSQLI_NUM));
				$totalpages = ceil($totalres / $max);
				
				echo '<div id="tnt_pagination">';
				echo '<a href="video.php?akcija=editiraj_video&strana='.($strana - 1).'">Назад</a>';
				for($i=1;$i<=$totalpages;$i++)
				{
					echo '<a href="video.php?akcija=editiraj_video&strana='.$i.'">'.$i.'</a>';
				}
				echo '<a href="video.php?akcija=editiraj_video&strana='.($strana + 1).'">Напред</a>';
				echo '</div>';			
	
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM video ORDER BY ID DESC LIMIT ".$limits.",$max");
					echo '<form action="" method="post">
						<div class="table">
						<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
						<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
							<table class="listing" cellpadding="0" cellspacing="0">
							<th class="first">Title</th>
							<th>Edit</th>
							<th>Publish</th>
							<th class="last">Delete</th>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr>
								<td class="first style2">'.$row['naslov'].'</td>
								<td><a href="admin-video-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-video-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-video-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td class="first style2">'.$row['naslov'].'</td>
									<td><a href="admin-video-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-video-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-video-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></td></tr>';
						}
					}
					echo '</table></div></form>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'neobjavi_video')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE video SET objavi='0' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully unpublish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'objavi_video')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE video SET objavi='1' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully unpublish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'brisi_video')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM video WHERE id='".$_GET['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully unpublish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['promeni_videoto']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE video SET naslov='".$_POST['naslov']."', sodrzina='".$_POST['sodrzina_video']."', link='".$_POST['link']."' WHERE id='".$_POST['id_video']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully unpublish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-video";</script>';
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

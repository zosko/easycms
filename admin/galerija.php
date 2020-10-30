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
$strana = $_GET['strana'];
if(empty($strana))
{
	$strana = 1;
}
$limits = ($strana - 1) * $max;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - Gallery</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/galerija.js"></script>
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
			<li><span><span><a href="admin-video">Video</a></span></span></li>
			<li class="active"><span><span>Gallery</span></span></li>
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
				<li><a href="admin-galerija-dodadi">Add new gallery</a></li>
				<li class="last"><a href="admin-galerija-lista">Edit gallery</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if($HTTP_GET_VARS['akcija'] == 'dodadi_galerija')
				{
					echo '<form enctype="multipart/form-data" method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<input type="hidden" value="0" id="theValue" />
									<tr><td width="100" class="first style2">Gallery name:</td><td class="first style2"><input onclick="dodadi_novo_slika()" size="30" type="text" name="ime" id="ime" /></td></tr>
									<tr><td class="first style2" colspan="2">Pictures</td></tr>
									<tr><td colspan="2"><div id="pole1" /></td></tr>
									<tr><td class="first style2">Publish now:</td><td class="first style2"><select name="objavi_vednas"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
								</table>
								<input type="submit" name="dodadi_galerijata" id="dodadi_galerijata" value="Add gallery" />
							</div>
						</form>';
				}
				if($HTTP_GET_VARS['akcija'] == 'editiraj_galerija')
				{
				$konektor = new baza_konektor();
				$totalres = mysql_result(mysql_query("SELECT COUNT(id) FROM galerija"),0);	
				$totalpages = ceil($totalres / $max);
				
				echo '<div id="tnt_pagination">';
				echo '<a href="galerija.php?akcija=editiraj_galerija&strana='.($strana - 1).'">Prev</a>';
				for($i=1;$i<=$totalpages;$i++)
				{
					echo '<a href="galerija.php?akcija=editiraj_galerija&strana='.$i.'">'.$i.'</a>';
				}
				echo '<a href="galerija.php?akcija=editiraj_galerija&strana='.($strana + 1).'">Next</a>';
				echo '</div>';
				
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM galerija ORDER BY ID DESC LIMIT ".$limits.",$max");
					echo '<form action="" method="post">
							<div class="table">
							<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
							<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
								<table class="listing" cellpadding="0" cellspacing="0">
									<th width="150" class="first">Name</th>
									<th width="50">Edit</th>
									<th width="50">Publish</th>
									<th width="50" class="last">Delete</th>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr>
								<td class="first style2"><a href="admin-galerija-promeni-'.$row['id'].'.html">'.$row['ime'].'</a></td>
								<td><a href="admin-galerija-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-galerija-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-galerija-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr>
									<td class="first style2"><a href="admin-galerija-promeni-'.$row['id'].'.html">'.$row['ime'].'</a></td>
									<td><a href="admin-galerija-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-galerija-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-galerija-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table></form>';
				}
				if($HTTP_GET_VARS['akcija'] == 'edit_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM galerija_sliki WHERE id_galerija='".$HTTP_GET_VARS['id']."' ORDER BY ID DESC");
					$id_gallerija = $HTTP_GET_VARS['id'];
					echo '<div class="table"><table class="listing" cellpadding="0" cellspacing="0">';
					$k=0;
					while($row = $konektor->fetchArray($izlez))
					{
						if($k>2) 
						{
							$k=0;
							echo "</tr><tr>";
						}
						echo '<td><img src="../images/galerii/_tumbs/'.$row['slika'].'" /><a href="admin-galerija-stavi-naslovna-galerija-'.$id_gallerija.'-slika-'.$row['id'].'.html"><br /><img src="sliki/publish_g.png"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin-galerija-izbrisi-slika-'.$row['id'].'.html"><img src="sliki/hr.gif"/></a></td>';
						$k++;
					}
					echo'</table></form>';
				}
				if(isset($_POST['dodadi_galerijata']))
				{
					$ime_galerija = "galerii";
					$momentalna_datoteka = getcwd(); //ВРАЌА МОМЕНТАЛНА ДАТОТЕКА
					$pom = "/../images/";
					$zz = "/";
					$tumberi = "/_tumbs/";
					$sirina = 150;
					$poleto = 0;
					$datoteka_golemi_sliki = $momentalna_datoteka.$pom.$ime_galerija.$zz;
					$datoteka_mali_sliki = $momentalna_datoteka.$pom.$ime_galerija.$tumberi;
					
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO galerija(ime,objavi) VALUES ('".addslashes($_POST['ime'])."','".$_POST['objavi_vednas']."')");
					
					$izlez = $konektor->query("SELECT * FROM galerija ORDER BY ID DESC LIMIT 1");
					$row = $konektor->fetchArray($izlez);
					$idto_od_galerija = $row['id'];
					
					while(list($key,$value) = each($_FILES['slika']['name']))
					{
						$filename = $value;
						$broj = rand(0,100000);
						if(!empty($value))
						{
							$prob = stripslashes($filename);
							$extension = getExtension($prob);
							$extension = strtolower($extension);
							if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "bmp") && ($extension != "png") && ($extension != "gif"))
							{
								echo "Picture ".$filename." is not uploaded<br />";
							}
							else
							{
								$ime=str_replace(" ","_",$filename);
								$ime = strtolower($ime);
								$ime = $broj."_".$ime;
								$bravo = move_uploaded_file($_FILES['slika']['tmp_name'][$key], $momentalna_datoteka.$pom.$ime_galerija.$zz.$ime);
								if(preg_match('/[.](jpg)$/', $ime)) {$image = imagecreatefromjpeg($datoteka_golemi_sliki . $ime);} 
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
								if($bravo)
								{
									$konektor = new baza_konektor();
									$izlez = $konektor->query("INSERT INTO galerija_sliki(id_galerija,slika) VALUES ('".$idto_od_galerija."','".$ime."')");
									echo "Successfully upload image: ".$ime."<br />";
								}
								else
								{
									echo "Error with upload on server<br />";
								}
							}
						}
						else
						{
							//echo "Во полето ".$poleto." не одбравте слика за качување на сервер<br />";
						}
						$poleto++;
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'neobjavi_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE galerija SET objavi='0' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'objavi_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE galerija SET objavi='1' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'naslovna_slika_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM galerija_sliki WHERE id='".$HTTP_GET_VARS['id']."'"); 
					$row = $konektor->fetchArray($izlez);
					$slikata_ime = $row['slika'];
					
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE galerija SET naslovna='".$slikata_ime."' WHERE id='".$HTTP_GET_VARS['id_galerija']."'"); 
					
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'brisi_slika_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM galerija_sliki WHERE id='".$HTTP_GET_VARS['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'brisi_galerija')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM galerija WHERE id='".$HTTP_GET_VARS['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
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

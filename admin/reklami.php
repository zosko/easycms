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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - Banners</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/all.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/paginator.css" type="text/css" />
	<script src="js/proverka.js" type="text/javascript"></script>
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
			<li><span><span><a href="admin-galerija">Gallery</a></span></span></li>
			<li class="active"><span><span>Banners</span></span></li>
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
				<li><a href="admin-reklami-dodadi">Add banner</a></li>
				<li class="last"><a href="admin-reklami-lista">Edit banner</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if($HTTP_GET_VARS['akcija'] == 'dodadi_reklama')
				{
					echo '<form enctype="multipart/form-data" method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2">Position:</td><td class="first style2">
									<select name="polozba_lista">
										<option value="">Choose</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
									</td></tr>
									<tr><td class="first style2">Title:</td><td class="first style2"><input type="text" name="oznaka" id="oznaka" size="50"/></td></tr>
									<tr><td class="first style2">Link:</td><td class="first style2"><input type="text" name="url_link" id="url_link" value="http://" size="50"/></td></tr>
									<tr><td class="first style2">Picture:</td><td class="first style2"><input size="38" type="file" name="image" id="image" /></td></tr>
									<tr><td class="first style2" colspan="2">
									<font color="red">
										banner 1 must be 580x80<br />
										banner 2 must be 600x80<br />
									</font></td></tr>
								</table>
								<input type="submit" name="dodadi_reklami" id="dodadi_reklami" value="Add banner" />
								<br />
								<img src="sliki/reklami_mapa.png" />
							</div>
						</form>';
				}
				if($HTTP_GET_VARS['akcija'] == 'editiraj_reklami')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM reklama ORDER BY ID DESC");
					echo '<div class="table">
							<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
							<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
							<table class="listing" cellpadding="0" cellspacing="0">
								<tr>
									<th class="first">Title</th>
									<th>Position</th>
									<th>Edit</th>
									<th>Publish</th>
									<th>Delete</th>
									<th>Clicks</th>
									<th class="last">Reset</th>
								</tr>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr><td class="first style2">'.$row['oznaka'].'</td>
								<td>'.$row['polozba'].'</td>
								<td><a href="admin-reklami-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-reklami-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-reklami-brisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
								<td><b>'.$row['poseti'].'</b></td>
								<td><a href="admin-reklami-resetiraj-'.$row['id'].'"><img src="sliki/add-icon.gif" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td class="first style2">'.$row['oznaka'].'</td>
								<td>'.$row['polozba'].'</td>
								<td><a href="admin-reklami-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-reklami-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-reklami-brisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
								<td><b>'.$row['poseti'].'</b></td>
								<td><a href="admin-reklami-resetiraj-'.$row['id'].'.html"><img src="sliki/add-icon.gif" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table></div>';
				}
				if($HTTP_GET_VARS['akcija'] == 'editiraj_reklama')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM reklama WHERE id='".$HTTP_GET_VARS['id']."' ORDER BY ID DESC");
					$row = $konektor->fetchArray($izlez);
					echo '<form enctype="multipart/form-data" method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2">Title:</td><td class="first style2"><input type="text" name="oznaka" id="oznaka" value="'.$row['oznaka'].'" size="50"/></td></tr>
									<tr><td class="first style2">Линк:</td><td class="first style2"><input type="text" name="url" id="url" value="'.$row['url'].'" size="50"/></td></tr>
									<tr><td class="first style2">Add new picture:</td><td class="first style2"><input size="38" type="file" name="image" id="image" /></td></tr>
									<tr><td colspan="2"><img src="../images/reklami/'.$row['link'].'" /></td></tr>
								</table>
								<input type="hidden" name="id_reklama" id="id_reklama" value="'.$HTTP_GET_VARS['id'].'" />
								<input type="submit" name="smeni_reklama" id="smeni_reklama" value="Edit banner" /> 
							</div>
						</form>';
				}
				if(isset($_POST['smeni_reklama']))
				{
					$momentalna_datoteka = getcwd();
					$pom = "/../images/reklami";
					$zz = "/";
					$datoteka_reklami = $momentalna_datoteka.$pom.$zz;
					$filename = stripslashes($_FILES['image']['name']);
					$extension = getExtension($filename);
					$extension = strtolower($extension);
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "bmp") && ($extension != "png") && ($extension != "gif"))
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'Unknown extension.', 'Error');</script> ";
						die;
					}
					else
					{
						$broj = rand(0,100000);
						$ime = $broj."_".$ime;
						$ime=str_replace(" ","_",$filename);
						$ime = strtolower($ime);
						$ime = $broj."_".$ime;
						$bravo = move_uploaded_file($_FILES['image']['tmp_name'], $datoteka_reklami.$ime);
						if ($bravo) 
						{
							echo 'Successfully uploaded<br />';
						}
						$konektor = new baza_konektor();
						$izlez = $konektor->query("UPDATE reklama SET link='".$ime."', oznaka='".addslashes($_POST['oznaka'])."', url='".$_POST['url']."' WHERE id='".$_POST['id_reklama']."'"); 
						if($izlez)
						{
							echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
							echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-reklami";</script>';
						}
						else
						{
							echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
						}
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'brisi_reklama')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM reklama WHERE id='".$HTTP_GET_VARS['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['dodadi_reklami']))
				{
					$momentalna_datoteka = getcwd();
					$pom = "/../images/reklami";
					$zz = "/";
					$datoteka_reklami = $momentalna_datoteka.$pom.$zz;
					$filename = stripslashes($_FILES['image']['name']);
					$extension = getExtension($filename);
					$extension = strtolower($extension);
					if($_POST['polozba_lista']=="")
					{
						echo "<script type=\"text/javascript\">alert('Choose banner position')</script> ";
						die;
					}
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "bmp") && ($extension != "png") && ($extension != "gif"))
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'Unknown extension.', 'Error');</script> ";
						die;
					}
					else
					{
						$broj = rand(0,100000);
						$ime = $broj."_".$ime;
						$ime=str_replace(" ","_",$filename);
						$ime = strtolower($ime);
						$ime = $broj."_".$ime;
						$bravo = move_uploaded_file($_FILES['image']['tmp_name'], $datoteka_reklami.$ime);
						if ($bravo) 
						{
							echo 'Successfully uploaded<br />';
						}
						$konektor = new baza_konektor();
						$izlez = $konektor->query("INSERT INTO reklama(link,oznaka,polozba,url) VALUES ('".$ime."','".addslashes($_POST['oznaka'])."','".$_POST['polozba_lista']."','".$_POST['url_link']."')"); 
						if($izlez)
						{
							echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
							echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-reklami";</script>';
						}
						else
						{
							echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
						}
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'objavi_reklama')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE reklama SET objavi='1' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'neobjavi_reklama')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE reklama SET objavi='0' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'resetiraj_reklama')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE reklama SET poseti='0' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully.', 'Success');</script>";
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

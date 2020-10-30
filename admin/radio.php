<?php
session_start();
if (!isset($_SESSION['logiran_user']) || $_SESSION['logiran_user'] != true || time() - $_SESSION['vreme'] > 1800) 
{
	header('Location: admin-login');
	exit;
}
require_once('../includes/konekcija/baza_konektor.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - Radio</title>
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
			<li><span><span><a href="admin-video">Video</a></span></span></li>
			<li><span><span><a href="admin-galerija">Gallery</a></span></span></li>
			<li><span><span><a href="admin-reklami">Banners</a></span></span></li>
			<li><span><span><a href="admin-korisnici">Users</a></span></span></li>
			<li class="active"><span><span>Radio</span></span></li>
			<li><span><span><a href="admin-anketa">Poll</a></span></span></li>
			<li><span><span><a href="admin-izlez">Logout</a></span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<h3>Menu</h3>
			<ul class="nav">
				<li><a href="admin-radio-dodadi">Add radio</a></li>
				<li class="last"><a href="admin-radio-lista">Edit radio</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'dodadi_radio')
				{
					echo '<form action="" method="post">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td width="80" class="first style2">Name:</td><td class="first style2"><input type="text" name="ime_radio" id="ime_radio" /></td></tr>
									<tr><td class="first style2">Link:</td><td class="first style2"><input size="50" type="text" name="link_radio" id="link_radio" /></td></tr>
									<tr><td class="first style2">Choose radio:</td><td class="first style2">
									<select name="vid_radio">
										<option value="">Choose</option>
										<option value="makedonsko">Our</option>
										<option value="stransko">Other</option>
									</select>
									</td></tr>
								</table>
								<input type="submit" name="prati_radio" id="prati_radio" value="Add radio" />
							</div>
						</form>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'lista_radio')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM radio WHERE vid='makedonsko'");
					echo '<div class="table">
							<table class="listing" cellpadding="0" cellspacing="0">
								<tr><td colspan="4"><b>Our radio</b></td></tr>
								<th>Name</th>
								<th>Publish</th>
								<th>Edit</th>
								<th>Delete</th>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr><td>'.$row['ime'].'</td>
								<td><a href="admin-radio-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td>'.$row['ime'].'</td>
								<td><a href="admin-radio-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table></div>';
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM radio WHERE vid='stransko'");
					echo '<div class="table"><table class="listing" cellpadding="0" cellspacing="0">
							<tr><td colspan="4"><b>Other radio</b></td></tr>
								<th>Name</th>
								<th>Publish</th>
								<th>Edit</th>
								<th>Delete</th>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr><td>'.$row['ime'].'</td>
								<td><a href="admin-radio-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td>'.$row['ime'].'</td>
								<td><a href="admin-radio-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-radio-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table></div>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'editiraj_radio')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM radio WHERE id='".$_GET['id']."' ORDER BY ID DESC");
					$row = $konektor->fetchArray($izlez);
					echo '<form method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2" width="50">Name:</td><td class="first style2"><input type="text" name="promeni_ime" id="promeni_ime" value="'.$row['ime'].'" /></td></tr>
									<tr><td class="first style2">Link:</td><td class="first style2"><input size="50" type="text" name="promeni_link" id="promeni_link" value="'.$row['link'].'" /></td></tr>
								</table>
								<input type="submit" name="smeni_radio" id="smeni_radio" value="Save" />
								<input type="hidden" name="id_radio" id="id_radio" value="'.$_GET['id'].'" />
							</div>
						</form>';
				}
				if(isset($_POST['prati_radio']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO radio(ime,link,vid) VALUES ('".$_POST['ime_radio']."','".$_POST['link_radio']."','".$_POST['vid_radio']."')"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-radio";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'brisi_radio')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM radio WHERE id='".$_GET['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'neobjavi_radio')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE radio SET objavi='0' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'objavi_radio')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE radio SET objavi='1' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['smeni_radio']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE radio SET ime='".$_POST['promeni_ime']."', link='".$_POST['promeni_link']."' WHERE id='".$_POST['id_radio']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-radio";</script>';
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

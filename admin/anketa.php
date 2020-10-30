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
	<title>Admin - Poll</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="js/anketa.js"></script>
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
			<li><span><span><a href="admin-radio">Radio</a></span></span></li>
			<li class="active"><span><span>Poll</span></span></li>
			<li><span><span><a href="admin-izlez">Logout</a></span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<h3>Menu</h3>
			<ul class="nav">
				<li><a href="admin-anketa-dodadi">Add poll</a></li>
				<li class="last"><a href="admin-anketa-lista">Edit poll</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'dodadi_anketa')
				{
					echo '<form action="" method="post">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<input type="hidden" value="0" id="theValue" />
									<tr><td class="first style2">Question:</td><td class="first style2"><input size="30" type="text" onclick="dodadi_novo()" name="prasanje_anketa" id="prasanje_anketa" /></td></tr>
									<tr><td class="first style2">Publish now:</td><td class="first style2"><select name="objavi_vednas_anketa"><option value="0">No</option><option value="1">Yes</option></select></td></tr>
									<tr><td colspan="2"><div id="pole" /></td></tr>
								</table>
								<input type="submit" name="dodadi_anketa" id="dodadi_anketa" value="Add poll" />
							</div>
						</form>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketi_lista')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM anketa ORDER BY ID DESC");
					echo '<div class="table">
							<table class="listing" cellpadding="0" cellspacing="0">
								<th class="first">Question</th>
								<th>Publish</th>
								<th>Edit</th>
								<th class="last">Delete</th>';
					while($row = $konektor->fetchArray($izlez))
					{
						$objavi = $row['objavi'];
						if($objavi == 0)
						{
							echo '<tr><td class="first style2">'.$row['prasanje'].'</td>
								<td><a href="admin-anketa-objavi-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-anketa-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-anketa-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
						if($objavi == 1)
						{
							echo '<tr><td class="first style2">'.$row['prasanje'].'</td>
								<td><a href="admin-anketa-neobjavi-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-anketa-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
								<td><a href="admin-anketa-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td></tr>';
						}
					}
					echo '</table>';
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketa_promeni')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM anketa WHERE id='".$_GET['id']."'");
					$rowz = $konektor->fetchArray($izlez);
					$id_anketata = $rowz['id'];
					echo '<form method="post" action=""><div class="table"><table class="listing" cellpadding="0" cellspacing="0">';
					
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM anketa_prasanja WHERE id_prasanje='".$id_anketata."'");
					echo '<tr><td colspan="3"><b>Question:</b></td><td ><input type="text" name="prasanje" id="prasanje" value="'.$rowz['prasanje'].'"/></td></tr>';
					while($row = $konektor->fetchArray($izlez))
					{
						echo '<tr><td class="first style2" width="100"><input  type="text" name="odgovor[]" id="odgovor" value="'.$row['odgovor'].'" /></td>
							<td width="100" class="first style2">
								<input type="hidden" name="id_odgovor" id="id_odgovor" value="'.$row['id'].'" />
							</td>
							<td class="first style2"><a href="admin-anketa-izbrisi-odgovor-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
							</tr>';
					}
					echo '</table>
					<input type="submit" name="promeni_odgovor" id="promeni_odgovor" value="Save" />
					</div></form>';
				}
				if(isset($_POST['promeni_odgovor']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM anketa WHERE id='".$_GET['id']."'");
				
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO anketa(prasanje,objavi) VALUES ('".$_POST['prasanje']."','1')"); 

					$izlez = $konektor->query("SELECT * FROM anketa ORDER BY ID DESC LIMIT 1");
					$row = $konektor->fetchArray($izlez);
					$idto_od_anketata = $row['id'];
					foreach($_POST['odgovor'] as $value)
					{
						$izlez = $konektor->query("INSERT INTO anketa_prasanja(id_prasanje,odgovor) VALUES ('".$idto_od_anketata."','".$value."')"); 
					}
					echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-anketa";</script>';
				
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketa_neobjavi')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE anketa SET objavi='0' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketa_objavi')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE anketa SET objavi='1' WHERE id='".$_GET['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketa_izbrisi')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM anketa WHERE id='".$_GET['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['dodadi_anketa']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO anketa(prasanje,objavi) VALUES ('".$_POST['prasanje_anketa']."','".$_POST['objavi_vednas_anketa']."')"); 

					$izlez = $konektor->query("SELECT * FROM anketa ORDER BY ID DESC LIMIT 1");
					$row = $konektor->fetchArray($izlez);
					$idto_od_anketata = $row['id'];
					foreach($_POST['odgovor'] as $value)
					{
						$izlez = $konektor->query("INSERT INTO anketa_prasanja(id_prasanje,odgovor) VALUES ('".$idto_od_anketata."','".$value."')"); 
					}
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-anketa";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_GET['akcija']) && $_GET['akcija'] == 'anketa_izbrisi_odgovor')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM anketa_prasanja WHERE id='".$_GET['id']."'");
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

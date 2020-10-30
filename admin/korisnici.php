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
	<title>Admin - Users</title>
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
			<li class="active"><span><span>Users</span></span></li>
			<li><span><span><a href="admin-radio">Radio</a></span></span></li>
			<li><span><span><a href="admin-anketa">Poll</a></span></span></li>
			<li><span><span><a href="admin-izlez">Logout</a></span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
			<h3>Menu</h3>
			<ul class="nav">
				<li><a href="admin-korisnici-dodadi">Add new user</a></li>
				<li class="last"><a href="admin-korisnici-lista">Edit users</a></li>
			</ul>
		</div>
		<div id="center-column">
			<?php
				if($HTTP_GET_VARS['akcija'] == 'korisnici')
				{
					echo '<form method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2" colspan="2">Add user:</td></tr>
									<tr><td class="first style2" width="100">Username:</td><td class="first style2"><input size="30" type="text" name="user" id="user" /></td></tr>
									<tr><td class="first style2">Password:</td><td class="first style2"><input size="30" type="password" name="pass" id="pass" /></td></tr>
									<tr><td class="first style2">First Name:</td><td class="first style2"><input size="30" type="text" name="ime" id="ime" /></td></tr>
									<tr><td class="first style2">Last Name:</td><td class="first style2"><input size="30" type="text" name="prezime" id="prezime" /></td></tr>
									<tr><td class="first style2">E-mail:</td><td class="first style2"><input size="30" type="text" name="email" id="email" /></td></tr>
								</table>
								<input type="submit" name="prati_korisnik" id="prati_korisnik" value="Add" />
							</div>
						</form>';
				}
				if($HTTP_GET_VARS['akcija'] == 'korisnik_lista')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM korisnik");
					echo '<div class="table">
							<img src="sliki/bg-th-left.gif" width="8" height="7" alt="" class="left" />
							<img src="sliki/bg-th-right.gif" width="7" height="7" alt="" class="right" />
							<table class="listing" cellpadding="0" cellspacing="0">
								<tr>
									<th class="first">Username</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>E-mail</th>
									<th>Activate</th>
									<th>Edit</th>
									<th class="last">Delete</th>
								</tr>';
					while ($row = $konektor->fetchArray($izlez))
					{
						$aktivacija = $row['aktivacija'];
						if($aktivacija == 0)
						{
							echo '<tr>
									<td class="first style2">'.$row['username'].'</td>
									<td class="first style2">'.$row['ime'].'</td>
									<td class="first style2">'.$row['prezime'].'</td>
									<td class="first style2">'.$row['email'].'</td>
									<td><a href="admin-korisnici-aktiviraj-'.$row['id'].'.html"><img src="sliki/hr.gif" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-korisnici-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-korisnici-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
								</tr>';
						}
						if($aktivacija == 1)
						{
							echo '<tr>
									<td class="first style2">'.$row['username'].'</td>
									<td class="first style2">'.$row['ime'].'</td>
									<td class="first style2">'.$row['prezime'].'</td>
									<td class="first style2">'.$row['email'].'</td>
									<td><a href="admin-korisnici-deaktiviraj-'.$row['id'].'.html"><img src="sliki/publish_g.png" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-korisnici-promeni-'.$row['id'].'.html"><img src="sliki/edit-icon.gif" width="16" height="16" alt="" /></a></td>
									<td><a href="admin-korisnici-izbrisi-'.$row['id'].'.html"><img src="sliki/icon-16-trash.png" width="16" height="16" alt="" /></a></td>
								</tr>';
						}
					}
					echo '</table></div>';
				}
				if($HTTP_GET_VARS['akcija'] == 'promeni_korisnik')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("SELECT * FROM korisnik WHERE id='".$HTTP_GET_VARS['id']."' ORDER BY ID DESC");
					$row = $konektor->fetchArray($izlez);
					echo'<form method="post" action="">
							<div class="table">
								<table class="listing" cellpadding="0" cellspacing="0">
									<tr><td class="first style2" width="100">Username:</td><td class="first style2"><input size="30" type="text" name="user" id="user" value="'.$row['username'].'"/></td></tr>
									<tr><td class="first style2">Password:</td><td class="first style2"><input size="30" type="password" name="pass" id="pass" value="'.$row['password'].'"/></td></tr>
									<tr><td class="first style2">First Name:</td><td class="first style2"><input size="30" type="text" name="ime" id="ime" value="'.$row['ime'].'"/></td></tr>
									<tr><td class="first style2">Last Name:</td><td class="first style2"><input size="30" type="text" name="prezime" id="prezime" value="'.$row['prezime'].'"/></td></tr>
									<tr><td class="first style2">E-mail:</td><td class="first style2"><input size="30" type="text" name="email" id="email" value="'.$row['email'].'"/></td></tr>
								</table>
								<input type="hidden" name="id_korisnik" id="id_korisnik" value="'.$HTTP_GET_VARS['id'].'"/>
								<input type="submit" name="smeni_korisnik" id="smeni_korisnik" value="Save"/>
							</div>
						</form>';
				}
				if($HTTP_GET_VARS['akcija'] == 'brisi_korisnik')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("DELETE FROM korisnik WHERE id='".$HTTP_GET_VARS['id']."'");
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['smeni_korisnik']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE korisnik SET username='".addslashes($_POST['user'])."', password='".addslashes($_POST['pass'])."', ime='".addslashes($_POST['ime'])."', prezime='".addslashes($_POST['prezime'])."', email='".addslashes($_POST['email'])."' WHERE id='".$_POST['id_korisnik']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-korisnici";</script>';
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'deaktiviraj_korisnik')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE korisnik SET aktivacija='0' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if($HTTP_GET_VARS['akcija'] == 'aktiviraj_korisnik')
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE korisnik SET aktivacija='1' WHERE id='".$HTTP_GET_VARS['id']."'"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
					}
					else
					{
						echo "<script type=\"text/javascript\">jAlert('error', 'There some error.', 'Error');</script> ";
					}
				}
				if(isset($_POST['prati_korisnik']))
				{
					$konektor = new baza_konektor();
					$izlez = $konektor->query("INSERT INTO korisnik(username,password,ime,prezime,email) VALUES ('".addslashes($_POST['user'])."','".addslashes($_POST['pass'])."','".addslashes($_POST['ime'])."','".addslashes($_POST['prezime'])."','".addslashes($_POST['email'])."')"); 
					if($izlez)
					{
						echo "<script type=\"text/javascript\">jAlert('success', 'Successfully publish.', 'Success');</script>";
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="admin-korisnici";</script>';
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

<?php
session_start();
if($_GET['akcija']=='logout')
{
	if (isset($_SESSION['logiran_user'])) 
	{
		unset($_SESSION['logiran_user']);
	}
		header('Location: ../pocetna');
		exit;
}
else
{
	if (!isset($_SESSION['logiran_user']) || $_SESSION['logiran_user'] != true || time() - $_SESSION['vreme'] > 1800) 
	{
		header('Location: admin-login');
		exit;
	}
}
require_once('../includes/konekcija/baza_konektor.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Admin - logout</title>
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
			<li><span><span><a href="admin-radio">Radio</a></span></span></li>
			<li><span><span><a href="admin-anketa">Poll</a></span></span></li>
			<li class="active"><span><span>Logout</span></span></li>
		</ul>
	</div>
	<div id="middle">
		<div id="left-column">
		</div>
		<div id="center-column">
				<?php
					$konektor = new baza_konektor();
					$izlez = $konektor->query("UPDATE korisnik SET najaven='0' WHERE username='".$_SESSION['user']."'");
					echo '<center><br /><br /><br /><h1>Are you sure?</h1><br /><br />';
					echo '<a href="admin-logout"><h1>YES</a> ';
					echo ' <a href="admin-pocetna">NO</h1></a>';
					echo '</center>';
				?>
		</div>
	</div>
	<div id="footer"><center><br />&copy; 2009-<?php echo date('Y');?></center></div>
</div>
</body>
</html>

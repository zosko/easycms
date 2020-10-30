<?
if(!file_exists("includes/konekcija/Podesi.php"))
	echo "<script>document.location.href='install'</script>";
?>
<?php
require_once('includes/konekcija/baza_konektor.php');

//БРОЈАЧ НА ПОСЕТИ
$konektor = new baza_konektor();
$ip_adresa = $_SERVER['REMOTE_ADDR'];
$izlez = $konektor->query("INSERT INTO statistiki(ip_adresa,data,ip_adresa_anketa) VALUES ('".$ip_adresa."','".date("Ydm")."','')"); 

//ЗЕМАЊЕ НА ПОДАТОЦИ ОД ПОДЕСУВАЊА
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM podesuvanja");
$row = $konektor->fetchArray($izlez);
$deskription = $row['seo_description'];
$keywords = $row['seo_keywords'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="mk" />
    <meta name="robots" content="all,index,follow" />
	<meta name="distribution" content="global" />
	<meta name="revisit-after" content="1 days" />
	<meta name="rating" content="general" />
    <meta name="author" lang="en" content="All: Bosko Petreski www.g6.mk; e-mail: info@g6.mk" />
    <meta name="copyright" lang="en" content="Webdesign: Bosko Petreski [www.g6.mk]; e-mail: info@g6.mk" />
    <meta name="description" content="<?php echo $deskription;?>" />
    <meta name="keywords" content="<?php echo $keywords;?>" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" />
    <!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="css/main-msie.css" /><![endif]-->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" />
    <link rel="stylesheet" media="print" type="text/css" href="css/print.css" />
	<link rel="stylesheet" href="css/tab.css" type="text/css" />
	<link rel="stylesheet" href="css/paginator.css" type="text/css" />
	<script type="text/javascript" src="js/vreme.js"></script>
	<script type="text/javascript" src="js/tab.js"></script>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="js/lightbox.js" type="text/javascript"></script>
	<script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.ui.draggable.js" type="text/javascript"></script>    
    <script src="js/jquery.alerts.js" type="text/javascript"></script>
	<link rel="shortcut icon" href="images/favicon.png" />
    <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
	<title>Portal</title>
</head>
<body>
<div id="main">
    <div id="header">
        <p id="logo"><img src="images/logo.gif" alt="" /></p>
<?php
	$konektor_prebaraj_modul = new baza_konektor();
	$izlez_prebaraj_modul = $konektor_prebaraj_modul->query("SELECT * FROM podesuvanja");
	$row_prebaraj_modul = $konektor_prebaraj_modul->fetchArray($izlez_prebaraj_modul);
	if($row_prebaraj_modul['prebaraj_modul'] == "1")
	{
?>
        <div id="slogan">
			<form action="prebaraj.php" method="post">
				<input type="text" name="baraj" id="baraj" class="input" size="30" />
				<input type="submit" value="Search"/>
			</form>
		</div>
<?php } //za prebaraj modulot ?>
    </div>
    <hr class="noscreen" />
    <div id="nav" class="box">
        <ul>
			<li><a href="pocetna">Home</a></li>
			<li><a href="kontakt">Contact</a></li>
        </ul>
        <p id="feeds">
            <?php echo date("m-d-Y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rss" class="ico-rss">RSS</a>
        </p>
    </div>
    <hr class="noscreen" />
    <div id="cols">
        <div id="cols-in" class="box">
            <div id="content">
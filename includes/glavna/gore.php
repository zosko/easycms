<?
//error_reporting(0);
if(!file_exists("includes/konekcija/Podesi.php"))
	echo "<script>document.location.href='install'</script>";
?>
<?php
require_once('includes/konekcija/baza_konektor.php');

//БРОЈАЧ НА ПОСЕТИ
$konektor = new baza_konektor();
$ip_adresa = $_SERVER['REMOTE_ADDR'];
$izlez = $konektor->query("INSERT INTO statistiki(ip_adresa,data) VALUES ('".$ip_adresa."','".date("Y-m-d")."')"); 

//ДЕНЕСКА ПОСЕТИ
$konektor_denesni_poseti = new baza_konektor();
$izlez_denesni_poseti = $konektor_denesni_poseti->query("SELECT COUNT(id) AS Denesni_Poseti FROM statistiki WHERE data = CURDATE() "); 
$row_denesni_poseti = $konektor_denesni_poseti->fetchArray($izlez_denesni_poseti);

//ЗЕМАЊЕ НА ПОДАТОЦИ ОД ПОДЕСУВАЊА
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM podesuvanja");
$row = $konektor->fetchArray($izlez);
$deskription = $row['seo_description'];
$keywords = $row['seo_keywords'];

//ЈАЗИК
$konektor_jazik = new baza_konektor();
$izlez_jazik = $konektor_jazik->query("SELECT * FROM jazik");
$row_jazik = $konektor_jazik->fetchArray($izlez_jazik);

//ДЕНЕШНИ ВЕСТИ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM vest WHERE datum = '".date("Y-m-d")."'");
$denesni_vesti = mysql_num_rows($izlez);
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
    <meta name="author" lang="en" content="Bosko Petreski" />
    <meta name="copyright" lang="en" content="Bosko Petreski" />
    <meta name="description" content="<?php echo $deskription;?>" />
    <meta name="keywords" content="<?php echo $keywords;?>" />
	<!-- templejtot -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" />
    <!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="css/main-msie.css" /><![endif]-->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" />
    <link rel="stylesheet" media="print" type="text/css" href="css/print.css" />
	<!-- templejtot -->
	<link rel="stylesheet" href="css/tab.css" type="text/css" />
	<link rel="stylesheet" href="css/tooltip.css" type="text/css" />
	<link rel="stylesheet" href="css/paginator.css" type="text/css" />
	<script type="text/javascript" src="js/anketa.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.vticker.1.4.js"></script>
	<script type="text/javascript" src="js/vreme.js"></script>
	<script type="text/javascript" src="js/jscroller-0.4.js"></script>	
	<script type="text/javascript" src="js/tab.js"></script>
	<script type="text/javascript" src="js/mail.js"></script>
	<script type="text/javascript" src="js/tooltip.js"></script>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	<script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.ui.draggable.js" type="text/javascript"></script>
    <script src="js/jquery.alerts.js" type="text/javascript"></script>
	<link rel="shortcut icon" href="images/favicon.png" />
    <link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="js/highslide-with-gallery.js" type="text/javascript"></script>
	<link rel="stylesheet" href="css/highslide.css" type="text/css" />
	<title>Portal</title>
	<script type="text/javascript">
		hs.graphicsDir = 'images/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		//hs.dimmingOpacity = 0.75;

		// Add the controlbar
		hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 5000,
			repeat: false,
			useControls: true,
			fixedControls: 'fit',
			overlayOptions: {
				opacity: 0.75,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
	</script>
	<script type="text/javascript">
	$(function(){
		$('#vesti-desno').vTicker({ 
			speed: 500,
			pause: 2000,
			animation: 'fade',
			mousePause: false,
			showItems: 4
		});
	});
	</script>
	<script type="text/javascript">
 $(document).ready(function(){
 
  // Add Scroller Object
  $jScroller.add("#scroller_container","#scroller","left",1);

  // Start Autoscroller
  $jScroller.start();
 });
</script>

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
			<form action="baraj" method="post">
				<input type="text" name="baraj" id="baraj" class="input" size="30" />
				<input type="submit" value="<?php echo $row_jazik['SEARCH'] ?>"/>
			</form>
		</div>
<?php } //za prebaraj modulot ?>
    </div>
    <hr class="noscreen" />
    <div id="nav" class="box">
        <ul>
			<li><a href="pocetna"><?php echo $row_jazik['HOME'] ?></a></li>
			<li><a href="kontakt"><?php echo $row_jazik['CONTACT'] ?></a></li>
        </ul>
        <p id="feeds">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y-m-d"); ?>
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="ico-sitemap"></a><? echo $row_jazik['VISITS_TODAY'].': '.$row_denesni_poseti['Denesni_Poseti'] ?>
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="denesni" id="ico-print"><? echo $denesni_vesti.' '.$row_jazik['NEWS_TODAY'] ?></a>
		   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rss" class="ico-rss"><?php echo $row_jazik['RSS'] ?></a>
        </p>
    </div>
    <hr class="noscreen" />
    <div id="cols">
        <div id="cols-in" class="box">
            <div id="content">
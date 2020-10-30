<?php
require_once('includes/konekcija/baza_konektor.php');

//ЗА БРОЕЊЕ НА КЛИКОВИ НА БАНЕР
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM reklama WHERE id='".$HTTP_GET_VARS['id']."'");
$row = $konektor->fetchArray($izlez);
$click = $row['poseti'];
$click = $click + 1;
$konektor = new baza_konektor();
$izlez = $konektor->query("UPDATE reklama SET poseti='".$click."' WHERE id='".$HTTP_GET_VARS['id']."'"); 

//ВРАЌА ЛИНК ДО РЕДИРЕКТОТ
$konektor = new baza_konektor();
$izlez = $konektor->query("SELECT * FROM reklama WHERE id='".$HTTP_GET_VARS['id']."'");
$row = $konektor->fetchArray($izlez);
$link = $row['url'];
?>
<html>
<head>
<meta http-equiv="Refresh" content="0; url=<?php echo $link; ?>"> 
</head>
<body>
</body>
</html>
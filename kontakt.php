<?php 
require_once('includes/konekcija/baza_konektor.php');
require_once('includes/glavna/gore.php'); 
?>
<center>
	<form method="post" action="">
		<div class="content-box box">
			<p class="nomt"><strong>Име:</strong><br />
			<input type="text" name="ime" id="ime" class="input" size="65"/></p>
			<p><strong>E-mail:</strong><br />
			<input type="text" name="email" id="email" class="input" size="65" /></p>
			<p><strong>Subject:</strong><br />
			<input type="text" name="naslov" id="naslov" class="input" size="65" /></p>
			<p><strong>Message</strong><br />
			<textarea name="poraka" id="poraka" rows="10" cols="95" class="input" style="width:500px;height:150px;" ></textarea></p>
			<p class="nomb t-cetner"><input type="submit" name="prati_poraka" id="prati_poraka" value="Send message" /></p>
		</div>
	</form>
</center>
<?php
if(isset($_POST['prati_poraka']))
{
	$konektor = new baza_konektor();
	$izlez = $konektor->query("INSERT INTO kontakt(ime,email,naslov,poraka) VALUES ('".$_POST['ime']."','".$_POST['email']."','".$_POST['naslov']."','".$_POST['poraka']."')"); 
	if($izlez)
	{
		echo "<script type=\"text/javascript\">jAlert('success', 'The message was successfully sent.', 'Success sent');</script> ";
	}
	else
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'The message was not successfully sent.', 'Error');</script> ";
	}
}
require_once('includes/glavna/dole.php'); ?>
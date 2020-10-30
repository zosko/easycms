<?php
session_start();
require_once('../includes/konekcija/baza_konektor.php');
	echo'<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript" src="js/shadedborder.js"></script>
			<script language="javascript" type="text/javascript">
				var holderBorder = RUZEE.ShadedBorder.create({ corner:20, border:2 });
			</script>
			<link href="css/style.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="css/paginator.css" type="text/css" />
		    <script src="js/jquery.js" type="text/javascript"></script>
			<script src="js/jquery.ui.draggable.js" type="text/javascript"></script>    
			<script src="js/jquery.alerts.js" type="text/javascript"></script>
			<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
			<title>Admin Login</title>
		</head>
		<body>
			<div id="content">
				<div id="innerholder">
					<h3><span>Admin Panel</span><hr></h3>
					<form method="post" action="">
						<div>
							<div id="label"><b>Username: </b></div>
							<div class="roundedfield" ><input type="text" id="username" name="username" /></div>
						</div>
						<div>
							<div id="label"><b>Password: </b></div>
							<div class="roundedfield"><input type="password" id="password" name="password" /></div>
						</div>
						<input type="submit" id="logiranje" name="logiranje" value="Login" />
					</form>
				</div>
			</div>
			<script language="javascript" type="text/javascript">  
				holderBorder.render(\'content\');
			</script>
		</body>';
if(isset($_POST['logiranje']))
{
	$user = addslashes($_POST['username']);
	$pass = addslashes($_POST['password']);
	$konektor = new baza_konektor();
	$izlez = $konektor->query("SELECT * FROM korisnik WHERE username='".$user."' AND password='".$pass."' AND aktivacija='1'");
	print_r("SELECT * FROM korisnik WHERE username='".$user."' AND password='".$pass."' AND aktivacija='1'");

	$rowCheck = mysqli_num_rows($izlez);
	if($rowCheck > 0)
	{
		$_SESSION['logiran_user'] = true;
		$_SESSION['user'] = $user;
		$_SESSION['vreme'] = time();
?>
<html>
	<head>
		<meta http-equiv="Refresh" content="0; url=admin-pocetna"> 
	</head>
	<body>
	</body>
</html>
<?php
	}
	else 
	{
		echo "<script type=\"text/javascript\">jAlert('error', 'Invalid username or password.', 'Error');</script>";
	}
}
?>
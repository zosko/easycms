<?php 
require_once ('Podesi.php');
class baza_konektor extends Podesi 
{
    var $Querito;
    var $link;
    function baza_konektor()
	{
        $podatok = Podesi::zemiPodatok();
        $host = $podatok['baza_server'];
        $db = $podatok['baza_ime'];
        $user = $podatok['baza_user'];
        $pass = $podatok['baza_pass'];
        $this->link = mysqli_connect($host, $user, $pass);
        $this->link->select_db($db);
    }
    function query($query) 
	{
        $this->Querito = $query;
        return mysqli_query($this->link, $query);
    }
    function fetchArray($result) 
	{
        return mysqli_fetch_array($result);
    }
    function close() 
	{
        mysqli_close($this->link);
    }
}
?>
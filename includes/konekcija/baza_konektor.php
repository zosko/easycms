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
        $this->link = mysql_connect($host, $user, $pass);
        mysql_select_db($db);
    }
    function query($query) 
	{
        $this->Querito = $query;
        return mysql_query($query, $this->link);
    }
    function fetchArray($result) 
	{
        return mysql_fetch_array($result);
    }
    function close() 
	{
        mysql_close($this->link);
    }
}
?>
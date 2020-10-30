<?
include("class.xml.parser.php");
include("class.weather.php");
$timeout=3*60*60;
if (isset($_ENV["TEMP"]))
  $cachedir=$_ENV["TEMP"];
else if (isset($_ENV["TMP"]))
  $cachedir=$_ENV["TMP"];
else if (isset($_ENV["TMPDIR"]))
  $cachedir=$_ENV["TMPDIR"];
else
  $cachedir="/tmp";
$cachedir=str_replace('\\\\','/',$cachedir);
if (substr($cachedir,-1)!='/') $cachedir.='/';
$weather = new weather("MKXX0001", 3600, "c", $cachedir);
$weather->parsecached();
print '<table border="1"><tr>';
print '<td align="center">';
print '<font color="#000" size="6"><b>'.$weather->forecast['CURRENT']['TEMP'] . "&deg;C </b></font>";
print '</td>';    	
print '<td align="center">';
print "<img src=http://l.yimg.com/us.yimg.com/i/us/we/52/".$weather->forecast['CURRENT']['CODE'].".gif><br>";
print $weather->forecast['0']['LOW'] . "&deg;C ";
print " - ";
print $weather->forecast['0']['HIGH']. "&deg;C ";
print '</td><td align="center">';
print "<img src=http://l.yimg.com/us.yimg.com/i/us/we/52/".$weather->forecast[1]['CODE'].".gif><br>";
print $weather->forecast[1]['LOW'] . "&deg;C ";
print " - ";
print $weather->forecast[1]['HIGH']. "&deg;C ";
print '</td> </tr>';
print '<tr>
<td align="center"><img src="images/design/temp-momentalna.gif"></td>
<td align="center"><img src="images/design/temp-denes.gif"></td>
<td align="center"><img src="images/design/temp-utre.gif"></td>
</tr></table>';
?>








var xmlHttp

function showWeather()
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }

var url="includes/vreme/vreme.php"
url=url+"?id="+document.getElementById("grad").value;
url=url+"&sid="+Math.random()
xmlHttp.open("GET",url,true)
xmlHttp.onreadystatechange=function() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("weather").innerHTML=xmlHttp.responseText 
 } 
}
xmlHttp.send(null)
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
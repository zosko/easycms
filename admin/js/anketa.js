function dodadi_novo() {
  var ni = document.getElementById('pole');
  var numi = document.getElementById('theValue');
  var num = (document.getElementById("theValue").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"Div";
  var newdiv = document.createElement('div');
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "Answer: <input type='text' name='odgovor[]' /><a href=\"javascript:;\" onclick=\"removeElementUpload(\'"+divIdName+"\')\"><img src=\"sliki/hr.gif\" width=\"16\" height=\"16\" /></a><a href=\"#\" onclick=\"dodadi_novo()\"><img src=\"sliki/add-icon.gif\" width=\"16\" height=\"16\" /></a>";
  ni.appendChild(newdiv);
}
function removeElementUpload(divNum) {
  var d = document.getElementById('pole');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
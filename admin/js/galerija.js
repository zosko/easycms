function dodadi_novo_slika() {
  var ni = document.getElementById('pole1');
  var numi = document.getElementById('theValue');
  var num = (document.getElementById("theValue").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"Div";
  var newdiv = document.createElement('div');
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "Picture: <input type='file' name='slika[]' /><a href=\"javascript:;\" onclick=\"removeElementUpload(\'"+divIdName+"\')\"><img src=\"sliki/hr.gif\" width=\"16\" height=\"16\" /></a><a href=\"#\" onclick=\"dodadi_novo_slika()\"><img src=\"sliki/add-icon.gif\" width=\"16\" height=\"16\" /></a>";
  ni.appendChild(newdiv);
}
function removeElementUpload(divNum) {
  var d = document.getElementById('pole1');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
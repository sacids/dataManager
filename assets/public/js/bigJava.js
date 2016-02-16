// JavaScript Document for ajax
var xmlhttp;

function showType(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("recruiter").innerHTML=xmlhttp.responseText;
}
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

//End of ajax function

//Function to limit max chars entered
 // function parameters are: field - the string field, count - the field for remaining
 //characters  number and max - the maximum number of characters  
 function CountLeft(field, count, max) {
 // if the length of the string in the input field is greater than the max value, trim it 
 if (field.value.length > max)
 field.value = field.value.substring(0, max);
 else
 // calculate the remaining characters  
 count.value = max - field.value.length;
 }
 
 //function to restrict form inputs
var phone = ",0123456789";
var numb = "0123456789";
var alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
function res(t,v){
var w = "";
for (i=0; i < t.value.length; i++) {
x = t.value.charAt(i);
if (v.indexOf(x,0) != -1)
w += x;
}
t.value = w;
}
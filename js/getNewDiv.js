var CityExFile = function(File,Sec,Str,DivTarget) { 
	getRequest(File+"?"+Sec+"="+Str , DisplayOffers,DivTarget);
} 

var DisplayOffers = function(data, DivTarget){ 
		document.getElementById(""+DivTarget+"").style.visibility = 'visible'; 
		document.getElementById(""+DivTarget+"").innerHTML = data;
} 

var HideDiv = function(DivTarget){
	document.getElementById(""+DivTarget+"").style.visibility = 'hidden';

}
var ShowDiv = function(DivTarget){
	document.getElementById(""+DivTarget+"").style.visibility = 'visible';

}
var ChangeDiv = function(DivTarget){
	var targetID = document.getElementById(""+DivTarget+"");
	if (targetID.style.visibility == 'hidden') {
		targetID.style.visibility = 'visible';
	}
	else {
		targetID.style.visibility = 'hidden';
	}
}
var ChangeTbl = function(DivTarget){
	var targetID = document.getElementById(""+DivTarget+"");
	if (targetID.style.display == 'none') {
		targetID.style.display = 'block';
	}
	else {
		targetID.style.display = 'none';
	}
}
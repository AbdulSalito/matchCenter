var addComp = function(DivTarget) { 
	//////getRequest("addComp1.php" , DisplayOffers,DivTarget);
	var targetID = document.getElementById(""+DivTarget+"");
	targetID.src="addComp1.php";
	targetID.height="500px";
	targetID.width="500px";
	if (targetID.style.visibility == 'hidden') {
		targetID.style.visibility = 'visible';
	}
	else {
		targetID.style.visibility = 'hidden';
	}
} 
var DisplayOffers = function(data, DivTarget){ 
	document.getElementById(""+DivTarget+"").innerHTML = data;
} 
var HideDiv = function(DivTarget){
	document.getElementById(""+DivTarget+"").style.visibility = 'hidden';

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
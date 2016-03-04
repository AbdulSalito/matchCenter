var matchDetailsAJAX = function(Str,HtmlTarget,HtmlType,DivTarget) { 
	getRequest("MatchAnalysis.php?match="+Str+"&"+HtmlTarget+"="+HtmlType+"" , DisplayOffers,DivTarget);
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
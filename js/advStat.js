var getStat = function(Str1,Str2,Str3,DivTarget) { 
	getRequest("getAdvStat.php?match="+Str1+"&team="+Str2+"&stat="+Str3+"" , DisplayOffers,DivTarget);
} 
var DisplayOffers = function(data, DivTarget) { 
	document.getElementById(""+DivTarget+"").innerHTML = data;
} 

var addStat = function(Str1,Str2,Str3,DivTarget) { 
	getRequest("getAdvStat.php?match="+Str1+"&player="+Str2+"&event="+Str3+"" , DisplayStat,DivTarget);
} 

var DisplayStat = function(data, DivTarget) { 
	document.getElementById(""+DivTarget+"").innerHTML = data;
} 
function CheckDraw(team1Result,team2Result,DivTarget){

   var team1 = document.getElementById( team1Result );
   var team2 = document.getElementById( team2Result );
	if (team1.value == team2.value) {
 	     getPenalties (team1Result,team2Result,DivTarget);
	      return false;
	   }
}

var getPenalties = function(team1,team2,DivTarget) { 
	getRequest("getMatchCheck.php?team1="+team1+"&team2="+team2+"&penalties=0", DisplayOffers, DivTarget);
} 

var DisplayOffers = function(data,DivTarget){ 
		document.getElementById(""+DivTarget+"").innerHTML = data;
} 
<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add league");
// insert the navigation
echo makeMenu();


// start the form with an empty text box to insert the new data
echo "<div id = \"maincontent\">\n";
echo "<form id = \"addClub\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> ≈÷«›… √‰œÌ… «·Ï œÊ—Ì </td>\n";
echo "	</tr>\n";
echo "	<tr>\n";
echo "	<td>«·„Ê”„</td>\n";
echo "	<td>\n <select name = \"season\" id =\"season\">";
$sqlSes = "SELECT * FROM season";
$queryresultSes = mysql_query($sqlSes)
		or die(mysql_error());
while ($rowSes = mysql_fetch_assoc($queryresultSes)) {
	$sesID = $rowSes['seasonID'];
	$start = $rowSes['seasonYearStart'];
	$end = $rowSes['seasonYearEnd'];
	echo "	<option value=\"$sesID\">$start - $end</option>";
}
mysql_free_result($queryresultSes);
echo "	</select></td>";
echo "<script type=\"text/javascript\" src=\"js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"js/test.js\"></script>\n";
echo "	<td><a href=\"javascript:addComp('CompFrame');\">add Competition</a></td>\n";
echo "<iframe id=\"CompFrame\" src=\"javascript:false;\" scrolling=\"no\" frameborder=\"0\"></iframe>";
echo "</tr>\n";
echo "	<tr>\n";
echo "	<td>«·»ÿÊ·…</td>\n";
echo "	<td>\n <select name = \"comp\" id =\"comp\">";
$sqlComp = "SELECT * FROM competition";
$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
while ($rowComp = mysql_fetch_assoc($queryresultComp)) {
	$CompID = $rowComp['compID'];
	$CompNameAr = $rowComp['compNameAr'];
	echo "	<option value=\"$CompID\">$CompNameAr</option>";
}
mysql_free_result($queryresultComp);
echo "	</select></td></tr>\n";
echo "	<tr>\n";
echo "	<td>\n  «·√‰œÌ… «·„‘«—ﬂ…";
echo " </td>\n";
echo "	<td>\n";
echo "<select name=\"matchs[]\" multiple=\"multiple\">";
$sqlMatch = "SELECT * FROM teams";
$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
	$teamID = $rowMatch['teamID'];
	$teamNameAr = $rowMatch['teamNameAr'];
	echo "	<option value=\"$teamID\">$teamNameAr</option>";
}
mysql_free_result($queryresultMatch);
echo "</select>";
echo " </td></tr>\n";
echo "	<tr>\n";
echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
echo "	</tr>\n";
echo "</table>\n";
echo "</form>\n";


if (isset($_POST['season']) && isset($_POST['comp'])) {
	$Season = $_POST['season'];
	$Comptetion = $_POST['comp'];
	$Matches = $_POST['matchs'];
	// START valdate if all required fields are not empty
	if ($Season != "" && $Comptetion != "") {
		if ($Matches){
			foreach ($Matches as $team1){
				foreach ($Matches as $team2){
					if ($team1 != $team2) {
							$sql = "INSERT INTO `matchcenter`.`match` (`matchID`, `matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
							`matchDate`, `matchStadium`, `matchReferee`)
							VALUES (NULL, '$Season', '$Comptetion', '$team1', '$team2', '2009-08-01', NULL, NULL);";
							mysql_query($sql) or die (mysql_error());
							// displaying the inserted data as a confirmation
					}
				}
			}
		}
		echo "<table  class=\"mcenter\">\n";
		echo "	<tr class=\"mcenter\">\n";
		echo "	<td colspan=\"2\"> „ «÷«›… «·‰«œÌ »‰Ã«Õ! </td>\n";
		echo "	</tr>\n";
		echo "</table>\n";
		echo "</div>\n";
		// end displaying data
		echo redirection();
		mysql_close($conn);
		// close database connection
		//die("<p>You have not entered all of the required fields</p>\n");
	}
	//die("<p>You have not entered all of the required fields</p>\n");
}
echo "</div>";
echo "<div id=\"addSec\"></div>";
// making footer
echo makeFooter();

?>
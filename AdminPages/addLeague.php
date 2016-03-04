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
echo "	</select></td></tr>\n";
echo "	<tr>\n";
echo "	<td>«·»ÿÊ·…</td>\n";
echo "	<td>\n <select name = \"comp\" id =\"comp\">";
$sqlComp = "SELECT * FROM competition WHERE compSys=0";
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
echo "	<td>\n  «—ÌŒ »œ«Ì… «·œÊ—Ì";
echo " </td>\n";
echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\">";
echo "<a href=\"javascript:displayDatePicker('dob');\">";
echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
echo " </td></tr>\n";

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
	$teamCity = $rowMatch['teamCity'];
	$sqlCity = "SELECT * FROM city WHERE cityID='$teamCity'";
	$queryresultCity = mysql_query($sqlCity)
			or die(mysql_error());
	$rowCity = mysql_fetch_assoc($queryresultCity);
	$CityAr = $rowCity['cityNameAr'];
	echo "	<option value=\"$teamID\">$teamNameAr - $CityAr</option>";
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
	$dateOfStart = $_POST['dob'];
	// START valdate if all required fields are not empty
	if ($Season != "" && $Comptetion != "") {
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$Comptetion'";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		$rowMatch = mysql_num_rows($queryresultMatch);
		if ($rowMatch == 0) {
			if ($Matches){
				foreach ($Matches as $team1){
					// get the match stadium by getting the default stadium ..................
					$sqlTeam = "SELECT * FROM `teams` WHERE teamID='$team1'";
					$queryresultTeam = mysql_query($sqlTeam)
						or die(mysql_error());
					$TeamRow = mysql_fetch_assoc($queryresultTeam);
					$teamStad = $TeamRow['teamStadium'];
					// ####################################################################
					foreach ($Matches as $team2){
						if ($team1 != $team2) {
							$sql = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
							`matchDate`, `matchStadium`, `matchTeamHomeKit`, `matchTeamAwayKit`)
							VALUES ('$Season', '$Comptetion', '$team1', '$team2', '$dateOfStart','$teamStad','1','2');";
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
			// end displaying data
			echo redirection();
			$redirection = "addMatchRound.php?season=$Season&comp=$Comptetion&round=1";
			header("Location: $redirection");
		} else {
			echo "<table  class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"2\"> „ «÷«›… «·œÊ—Ì „”»ﬁ«</td>\n";
			echo "	</tr>\n";
			echo "</table>\n";
			$redirection = "addMatchRound.php?season=$Season&comp=$Comptetion&round=1";
			header("Location: $redirection");
		}
		mysql_free_result($queryresultMatch);
		mysql_close($conn);
		// close database connection
		//die("<p>You have not entered all of the required fields</p>\n");
	}
	//die("<p>You have not entered all of the required fields</p>\n");
}
echo "</div>";

// making footer
echo makeFooter();

?>
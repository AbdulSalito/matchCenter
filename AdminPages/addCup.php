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
echo "<form id = \"addCup\" action = \"\" method = \"post\">\n";
echo "<table  class=\"mcenter\">\n";
echo "	<tr class=\"mcenter\">\n";
echo "	<td colspan=\"2\"> ≈÷«›… „”«»ﬁ… ﬂ√”</td>\n";
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

if (isset($_GET['comp'])) {
	$compSystem = $_GET['comp'];
	echo "	<tr>\n";
	echo "	<td>‰Ê⁄ «·»ÿÊ·…</td>\n";
	echo "	<td>\n";
	if ($compSystem == 1) {
		echo "<input type=\"radio\" checked=\"checked\" name=\"compSys\" onclick=\"window.location='addCup.php?comp=1';\" value=\"1\">ﬂ√” Œ—ÊÃ „€·Ê» ";
		echo "<input type=\"radio\" name=\"compSys\" onclick=\"window.location='addCupGroupStage.php';\" value=\"2\">ﬂ√” „Ã„Ê⁄« ";
	}
	elseif ($compSystem == 2) {
		echo "<input type=\"radio\" name=\"compSys\" onclick=\"window.location='addCup.php?comp=1';\" value=\"1\">ﬂ√” Œ—ÊÃ „€·Ê»";
		echo "<input type=\"radio\" checked=\"checked\" name=\"compSys\" onclick=\"window.location='addCupGroupStage.php';\" value=\"2\">ﬂ√” „Ã„Ê⁄« ";
	}
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n  «—ÌŒ »œ«Ì… «·»ÿÊ·…";
	echo " </td>\n";
	echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\">";
	echo "<a href=\"javascript:displayDatePicker('dob');\">";
	echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
	echo " </td></tr>\n";

	echo "	<td>«·»ÿÊ·…</td>\n";
	echo "	<td>\n <select name = \"comptetion\" id =\"comptetion\">";
	$sqlComp = "SELECT * FROM competition WHERE compSys='$compSystem'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	while ($rowComp = mysql_fetch_assoc($queryresultComp)) {
		$CompID = $rowComp['compID'];
		$CompNameAr = $rowComp['compNameAr'];
		echo "	<option value=\"$CompID\">$CompNameAr</option>";
	}
	mysql_free_result($queryresultComp);
	echo "	</select></td></tr>\n";
	if ($compSystem == 1) {
		echo "	<tr>\n";
		echo "	<td>\n ⁄œœ «·√‰œÌ… «·„‘«—ﬂ…";
		echo " </td>\n";
		echo "	<td>\n";
		echo "<select name=\"teamsCount\" onchange=\"CityExFile('getCupSys.php','teams',this.value,'ChooseTeams')\">";
		$numberOfTeams = 2;
		echo "	<option value=\"\"> </option>";
		for ($i = 1; $i <= 3; $i ++) {
			$numberOfTeams *= 2;
			echo "	<option value=\"$numberOfTeams\">$numberOfTeams</option>";
		}
		echo "</select>";
		echo " </td></tr>\n";

		echo "	<tr>\n";
		echo "	<td colspan=\"2\">\n";
		echo "<div id=\"ChooseTeams\"></div>";
		echo " </td></tr>\n";
	}

	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "	</tr>\n";
}

else {
	echo "	<tr>\n";
	echo "	<td>‰Ê⁄ «·»ÿÊ·…</td>\n";
	echo "	<td>\n";
	echo "<input type=\"radio\" name=\"compSys\" onclick=\"window.location='addCup.php?comp=1';\" value=\"1\">ﬂ√” Œ—ÊÃ „€·Ê»";
	echo "<input type=\"radio\" name=\"compSys\" onclick=\"window.location='addCupGroupStage.php';\" value=\"2\">ﬂ√” „Ã„Ê⁄« ";
	echo "</td></tr>\n";
}
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['comptetion'])) {
	$Season = $_POST['season'];
	$Comptetion = $_POST['comptetion'];
	$TeamsCount = $_POST['teamsCount'];
	$dateOfStart = $_POST['dob'];
	$AutoNumber = 0;
	if ($TeamsCount != "" && $Comptetion != "") {
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$Season' AND matchComp='$Comptetion'";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		$rowMatch = mysql_num_rows($queryresultMatch);
		if ($rowMatch == 0) {
			$MatchNumber = $TeamsCount / 2;
			$round16 = 0;
			$round8 = 0;
			$round4 = 0;
			$round3 = 0;
			$round2 = 0;
			if (isset($_POST['RoundTrip'])) {
				$RoundTrip = $_POST['RoundTrip'];
				foreach ($RoundTrip as $matchs){
					switch($matchs){
						case 16:
							$round16 = $matchs;
							break;
						case 8:
							$round8 = $matchs;
							break;
						case 4:
							$round4 = $matchs;
							break;
						case 3:
							$round3 = $matchs;
							break;
						case 2:
							$round2 = $matchs;
							break;
					} // switch
				}
			}
			// First round insert
			for ($i1 = 1; $i1 <= $MatchNumber; $i1++) {
				for ($i2 = 1; $i2 <= 2; $i2++) {
					if ($i2 % 2 == 0) {
						$team2IDNumber = "$i1$i2";
						$team2ID = "team$team2IDNumber";
						$team2IDPost = $_POST[$team2ID];
					}
					else {
						$team1IDNumber = "$i1$i2";
						$team1ID = "team$team1IDNumber";
						$team1IDPost = $_POST[$team1ID];
					}
					$AutoNumber ++;
					if ($AutoNumber == 2) {
						if ($round16 == $TeamsCount || $round8 == $TeamsCount || $round4 == $TeamsCount || $round2 == $TeamsCount) {
							$sql1 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchStadium`, `matchReferee`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '$team1IDPost', '$team2IDPost', '$dateOfStart', '0', '0', '$TeamsCount' , '$i1');";
							mysql_query($sql1) or die (mysql_error());
							$sql2 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchStadium`, `matchReferee`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '$team2IDPost', '$team1IDPost', '$dateOfStart', '0', '0', '$TeamsCount' , '$i1');";
							mysql_query($sql2) or die (mysql_error());
						}
						else {
							$sql = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchStadium`, `matchReferee`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '$team1IDPost', '$team2IDPost', '$dateOfStart', '0', '0', '$TeamsCount' , '$i1');";
							mysql_query($sql) or die (mysql_error());
						}
						$AutoNumber = 0;
					}
				}
			}
			// final Rounds Insert
			while($MatchNumber % 2 == 0){
				for ($i = 1; $i <= ($MatchNumber/2); $i++) {
					if ($round8 == $MatchNumber || $round4 == $MatchNumber || $round2 == $MatchNumber) {
						$sql1 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$MatchNumber' , '$i');";
						mysql_query($sql1) or die (mysql_error());
						$sql2 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$MatchNumber' , '$i');";
						mysql_query($sql2) or die (mysql_error());
					}
					else {
						$sql = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$MatchNumber' , '$i');";
						mysql_query($sql) or die (mysql_error());
					}
				}
				$MatchNumber /= 2;
			}
			if ($round3 == 3) {
				$sql = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
						   `matchDate`, `matchRound`, `matchGroup`)
						   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '3' , '3');";
				mysql_query($sql) or die (mysql_error());
			}
			// End final round insert
			echo "<table  class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"2\"> „ «÷«›… «·ﬂ√” »‰Ã«Õ! </td>\n";
			echo "	</tr>\n";
			echo "</table>\n";
			echo "</div>\n";
			// end displaying data
			echo redirection();
		} else {
			echo "<table  class=\"mcenter\">\n";
			echo "	<tr class=\"mcenter\">\n";
			echo "	<td colspan=\"2\"> „ «÷«›… «·ﬂ√” „”»ﬁ«</td>\n";
			echo "	</tr>\n";
			echo "</table>\n";
			echo "</div>\n";

		}
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
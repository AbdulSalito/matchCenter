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

if (isset($_GET['Season']) && isset($_GET['Comp'])) {
	$seasonStart = $_GET['Season'];
	$Comp = $_GET['Comp'];
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\">";
	$sqlSesCheck = "SELECT * FROM season WHERE seasonID='$seasonStart'";
	$queryresultSesCheck = mysql_query($sqlSesCheck)
	or die(mysql_error());
	$rowCheck = mysql_fetch_assoc($queryresultSesCheck);
	$YearCheck = $rowCheck['seasonYearEnd'];
	$sqlSes = "SELECT * FROM season WHERE seasonYearStart='$YearCheck' OR seasonYearEnd='$YearCheck'";
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
	echo "	<td>\n «·»ÿÊ·… ";
	echo " </td>\n";
	echo "	<td>\n";
	echo CompAr($Comp);
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td>\n ⁄œœ «·√‰œÌ… «·„‘«—ﬂ…";
	echo " </td>\n";
	echo "	<td>\n";
	echo " 32 ›—Ìﬁ „ﬁ”„… ⁄·Ï 8 „Ã„Ê⁄« ";
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td>\n  «—ÌŒ »œ«Ì… «·ÃÊ·…";
	echo " </td>\n";
	echo "	<td><input type=\"text\" name=\"dob\" id=\"dob\">";
	echo "<a href=\"javascript:displayDatePicker('dob');\">";
	echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td>\n";
	echo " </td>\n";
	echo "	<td>";
	for ($i = 1 ; $i <= 8 ; $i++) {
		echo "<input type=\"radio\" name=\"Stage\" onclick=\"CityExFile('getCupSys.php','Season=$seasonStart&Comp=$Comp&Group=$i&teamsGroups','32','ChooseTeams');\" value=\"32$i\"> «·„Ã„Ê⁄…$i ";
	}
	echo "<br>";
	echo "<input type=\"radio\" name=\"Stage\" onclick=\"CityExFile('getCupSys.php','teamsGroups',this.value,'ChooseTeams');\" value=\"16\"> œÊ— «·‹16 ";
	echo "<input type=\"radio\" name=\"Stage\" onclick=\"CityExFile('getCupSys.php','teamsGroups',this.value,'ChooseTeams');\" value=\"8\"> œÊ— «·‹8 ";
	echo "<input type=\"radio\" name=\"Stage\" onclick=\"CityExFile('getCupSys.php','teamsGroups',this.value,'ChooseTeams');\" value=\"4\"> œÊ— «·‹4 ";
	echo "<input type=\"radio\" name=\"Stage\" onclick=\"CityExFile('getCupSys.php','teamsGroups',this.value,'ChooseTeams');\" value=\"2\"> «·‰Â«∆Ì ";
	echo " </td></tr>\n";


	echo "	<tr>\n";
	echo "	<td colspan=\"2\">\n";
	echo "<div id=\"ChooseTeams\"></div>";
	echo " </td></tr>\n";

	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "<script type=\"text/javascript\" src=\"../js/DatePicker1.js\"></script>";
	echo "<script type=\"text/javascript\" src=\"../js/getRequest.js\"></script>\n<script type=\"text/javascript\" src=\"../js/getNewDiv.js\"></script>\n";
	echo "	</tr>\n";

}

elseif (isset($_GET['Season'])) {
	$seasonStart = $_GET['Season'];
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\">";
	$sqlSesCheck = "SELECT * FROM season WHERE seasonID='$seasonStart'";
	$queryresultSesCheck = mysql_query($sqlSesCheck)
		or die(mysql_error());
	$rowCheck = mysql_fetch_assoc($queryresultSesCheck);
	$YearCheck = $rowCheck['seasonYearEnd'];
	$sqlSes = "SELECT * FROM season WHERE seasonYearStart='$YearCheck' OR seasonYearEnd='$YearCheck'";
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

	echo "	<td>«·»ÿÊ·…</td>\n";
	echo "	<td>\n <select name = \"comptetion\" id =\"comptetion\" onchange=\"window.location='addCupGroupStage.php?Season=$seasonStart&Comp='+this.value\">";
	$sqlComp = "SELECT * FROM competition WHERE compSys='2'";
	$queryresultComp = mysql_query($sqlComp)
	or die(mysql_error());
	echo "	<option value=\"\"></option>";
	while ($rowComp = mysql_fetch_assoc($queryresultComp)) {
		$CompID = $rowComp['compID'];
		$CompNameAr = $rowComp['compNameAr'];
		echo "	<option value=\"$CompID\">$CompNameAr</option>";
	}
	mysql_free_result($queryresultComp);
	echo "	</select></td></tr>\n";
}

else {
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\" onchange=\"window.location='addCupGroupStage.php?Season='+this.value\">";
	$sqlSes = "SELECT * FROM season";
	$queryresultSes = mysql_query($sqlSes)
			or die(mysql_error());
	echo "	<option value=\"\"> </option>";
	while ($rowSes = mysql_fetch_assoc($queryresultSes)) {
		$sesID = $rowSes['seasonID'];
		$start = $rowSes['seasonYearStart'];
		$end = $rowSes['seasonYearEnd'];
		echo "	<option value=\"$sesID\">$start - $end</option>";
	}
	mysql_free_result($queryresultSes);
	echo "	</select></td></tr>\n";
}
echo "</table>\n";
echo "</form>\n";

if (isset($_POST['season']) && isset($_GET['Comp']) && isset($_POST['Stage'])) {
	$Season = $_POST['season'];
	$Comptetion = $_GET['Comp'];
	$dateOfStart = $_POST['dob'];
	$Stage = $_POST['Stage'];
	if ($Stage > 320) {
		switch($Stage){
			case 321:
				$matchRound = 32;
				$matchGroup = 1;
				break;
			case 322:
				$matchRound = 32;
				$matchGroup = 2;
				break;
			case 323:
				$matchRound = 32;
				$matchGroup = 3;
				break;
			case 324:
				$matchRound = 32;
				$matchGroup = 4;
				break;
			case 325:
				$matchRound = 32;
				$matchGroup = 5;
				break;
			case 326:
				$matchRound = 32;
				$matchGroup = 6;
				break;
			case 327:
				$matchRound = 32;
				$matchGroup = 7;
				break;
			case 328:
				$matchRound = 32;
				$matchGroup = 8;
				break;
		} // switch
		$matchs = $_POST['matchs'];
		if ($matchs != "" && $Comptetion != "") {
			foreach ($matchs as $team1){
				foreach ($matchs as $team2){
					if ($team1 != $team2) {
						$sql1 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
				  		 `matchDate`, `matchRound`, `matchGroup`)
				  		 VALUES ('$Season', '$Comptetion', '$team1', '$team2', '$dateOfStart', '$matchRound' , '$matchGroup');";
						mysql_query($sql1) or die (mysql_error());
					}
				}
			}
			echo " „ «÷«›… ›—ﬁ «·„Ã„Ê⁄…$matchGroup ";
		}
	}

	else {
		// First round insert
		if (isset($_POST['RoundTripMatch'])) {
			$RoundTrip = $_POST['RoundTripMatch'];
		} else {
			$RoundTrip = 0;
		}

		// final Rounds Insert
		for ($j = 1; $j <= ($Stage/2); $j++) {
			if ( $RoundTrip != 0) {
				$sql1 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
				   `matchDate`, `matchRound`, `matchGroup`)
				   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$Stage' , '$j');";
				mysql_query($sql1) or die (mysql_error());
				$sql2 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
				   `matchDate`, `matchRound`, `matchGroup`)
				   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$Stage' , '$j');";
				mysql_query($sql2) or die (mysql_error());
			} else {
				$sql1 = "INSERT INTO `matchcenter`.`match` (`matchSeason`, `matchComp`, `matchTeamHome`, `matchTeamAway`,
				   `matchDate`, `matchRound`, `matchGroup`)
				   VALUES ('$Season', '$Comptetion', '0', '0', '$dateOfStart', '$Stage' , '$j');";
				mysql_query($sql1) or die (mysql_error());
			}
		}
		// End final round insert
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

// making footer
echo makeFooter();

?>
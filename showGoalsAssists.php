<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeader("'Show Goals and Assists");
// insert the navigation
echo makeMenu();

if (isset($_GET["Season"]) && isset($_GET["Team"])) {
	$Season = $_GET["Season"];
	$TeamIdGet = $_GET["Team"];

	echo "<div id = \"maincontent\">\n";
	echo "<table dir=\"rtl\" cellSpacing=\"1\" cellPadding=\"0\" id=\"table1\" border=\"1\" width=\"550\" bordercolor=\"#FFFFFF\" style=\"border-collapse: collapse\">\n";
	// get the start date and end date of the selected season
	$sqlSes = "SELECT * FROM season WHERE seasonID='$Season'";
	$queryresultSes = mysql_query($sqlSes)
		or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$start = $rowSes['seasonYearStart'];
	$end = $rowSes['seasonYearEnd'];
	$dateStarting = "$start-07-01";
	$dateFinishin = "$end-06-01";
	mysql_free_result($queryresultSes);

	$sqlCreatTempror = "CREATE TEMPORARY TABLE GoalAssist (
		player int(12),
		goals int(3),
		assist int(2),
		pCause int(2))";
	mysql_query($sqlCreatTempror) or die (mysql_error());

	if (isset($_GET["League"])) {
		$LeagueName = $_GET["League"];
		$WhereClause = "matchComp='$LeagueName' AND (matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND ";
	} else {
		$WhereClause = "(matchDate >= '$dateStarting' AND matchDate <= '$dateFinishin') AND ";
	}
	$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$Season' AND inseasonTeam='$TeamIdGet' AND inseasonType='0'";
	$queryresultInSes = mysql_query($sqlInSes)
		or die(mysql_error());
	$goals = 0;
	$assist = 0;
	$penaltyCause = 0;
	$outputTable = "";
	while($rowInSes = mysql_fetch_assoc($queryresultInSes)){
		// get the start date and end date of the selected season
		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE $WhereClause
		(matchTeamHome='$TeamIdGet' OR matchTeamAway='$TeamIdGet') ORDER BY matchDate,matchTime,matchRound,matchTime,matchTeamHome";
		$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
		$playerInSes = $rowInSes['inseasonMember'];
		while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
			$mathsPlayed = $rowMatch['matchID'];

			$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisPlayer='$playerInSes' AND analysisMatch='$mathsPlayed'";
			$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
				or die(mysql_error());
			while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
				$event = $rowMatchAnalysis['analysisEvent'];
				$penalty = $rowMatchAnalysis['analysisPenalty'];
				$analyTeam = $rowMatchAnalysis['analysisTeam'];

				if ($event == "2") {
					$goals ++;
				}
				elseif ($event == "5") {
					$assist ++;
				}
				elseif ($event == "0" && $penalty == "1" && $analyTeam == $TeamIdGet) {
					$penaltyCause ++;
				}
			}
		}
		if ($goals != 0 OR $assist != 0 OR $penaltyCause != 0) {
			$sqlTableStanding = "INSERT INTO GoalAssist (player, goals, assist, pCause)
				VALUES ('$playerInSes','$goals','$assist','$penaltyCause');";
			mysql_query($sqlTableStanding) or die (mysql_error());

		}
		$goals = 0;
		$assist = 0;
		$penaltyCause = 0;

	}

	$outputTableBegin = " <tr class=\"dates\"> ";
	$outputTableBegin .= " <td>«··«⁄»</td>\n";
	$outputTableBegin .= " <td>«Âœ«›</td>\n";
	$outputTableBegin .= " <td> „—Ì—«  Õ«”„…</td>\n";
	$outputTableBegin .= " <td> ”»» ›Ì ÷—»… Ã“«¡</td>\n";
	$outputTableBegin .= "</tr>\n";
	$outputTableBegin .= "";

	$sqlTblStanding = "SELECT * FROM GoalAssist ORDER BY goals DESC,assist DESC,pCause DESC";
	$queryresultTblStanding = mysql_query($sqlTblStanding)
		or die(mysql_error());
	$NewTr = 1;
	while($rowTbl = mysql_fetch_assoc($queryresultTblStanding)){
		$playerID = $rowTbl['player'];
		$goalScored = $rowTbl['goals'];
		$assistMade = $rowTbl['assist'];
		$pCause = $rowTbl['pCause'];

		if ($NewTr == 2) {
			$outputTable .= "<tr class=\"hilalMatches\">";
			$NewTr = 0;
		} else {
			$outputTable .= "<tr class=\"Matches\">";
		}
		$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerID'";
		$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
		$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
		$playerID = $rowPlayer['playerID'];
		$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
		$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
		$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];

		$outputTable .= "<td class=\"whiteBorder\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $goalScored </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $assistMade </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $pCause </td>";
		$outputTable .= "</tr>";
		$NewTr ++ ;
	}
	echo $outputTableBegin;
	echo $outputTable;
	echo "</table>";
	mysql_free_result($queryresultMatch);
}

echo "</table>\n";
echo "</div>";

// making footer
echo makeFooter();

?>
<?php
	// ask for the functions from it's file
	require_once('Functions.php');
include 'AdminPages/db_conn.php';
// insert the header
echo makeHeaderSimple("'Show Minutes","ar");
// insert the navigation
//echo makeMenu();

if (isset($_GET["Season"]) && isset($_GET["Team"])) {
	$Season = $_GET["Season"];
	$TeamIdGet = $_GET["Team"];

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

	$sqlCreatTempror = "CREATE TEMPORARY TABLE Minutes (
		player int(12),
		played int(3),
		linedUp int(3),
		sub int(2),
		minutes int(5))";
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
	$matchPlayed = 0;
	$matchPlayedLinedUp = 0;
	$matchPlayedSubs = 0;
	$matchPlayedMins = 0;
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

			$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$mathsPlayed' AND inmatchTeam='$TeamIdGet' AND inmatchMember='$playerInSes' AND
			(inmatchType=0 OR inmatchType=5 OR inmatchType=6 )"; // inmatchType=1 OR
			$queryresultInMatch = mysql_query($sqlInMatch)
				or die(mysql_error());
			while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
				$inMatchType = $rowInMatch['inmatchType'];
				$inMatchMatch = $rowInMatch['inmatchMatch'];
				$sqlMatchAnalyHalf = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$mathsPlayed' AND analysisHalf='0'
					AND analysisEvent='0' AND analysisPlayer='0' ORDER BY analysisID DESC";
				$queryresultMatchAnalyHalf = mysql_query($sqlMatchAnalyHalf)
					or die(mysql_error());
				if (mysql_num_rows($queryresultMatchAnalyHalf) == 0) {
					break 1;
				}
				while ($rowMatchAnalyHalf = mysql_fetch_assoc($queryresultMatchAnalyHalf)) {
					$matchMin = $rowMatchAnalyHalf['analysisMins'];
					if ($matchMin == 120) {
						$matchMinute = 120;
						break;
					}
					elseif ($matchMin == 90) {
						$matchMinute = 90;
						break;
					}
				}
				switch($inMatchType){
					case 0:
						$matchPlayed ++;
						$matchPlayedLinedUp ++;
						$matchPlayedMins += $matchMinute;
						break;
					case 5:
						//$matchPlayedLinedUp ++;
						$matchPlayed ++;
						$matchPlayedSubs ++;
						$sqlMatchAnaly = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$mathsPlayed' AND analysisPlayer='$playerInSes' AND analysisEvent='1'";
						$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
							or die(mysql_error());
						$rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly);
						$MatchAnalyMin = $rowMatchAnaly['analysisMins'];
						$matchPlayedMins += ($matchMinute - $MatchAnalyMin);
						break;
					case 6:
						$matchPlayed ++;
						$matchPlayedLinedUp ++;;
						$sqlMatchAnaly = "SELECT analysisMins FROM matchanalysis WHERE analysisMatch='$mathsPlayed' AND analysisPlayer='$playerInSes' AND (analysisEvent='1' OR analysisEvent='4')";
						$queryresultMatchAnaly = mysql_query($sqlMatchAnaly)
							or die(mysql_error());
						$rowMatchAnaly = mysql_fetch_assoc($queryresultMatchAnaly);
						$MatchAnalyMin = $rowMatchAnaly['analysisMins'];

						$matchPlayedMins += $MatchAnalyMin;
						break;
				} // switch
			}
		}
		if ($matchPlayedMins != 0) {

			$sqlTableStanding = "INSERT INTO Minutes (player, played, linedUp, sub, minutes)
				VALUES ('$playerInSes','$matchPlayed','$matchPlayedLinedUp','$matchPlayedSubs','$matchPlayedMins');";
			mysql_query($sqlTableStanding) or die (mysql_error());

		}
		$matchPlayed = 0;
		$matchPlayedLinedUp = 0;
		$matchPlayedSubs = 0;
		$matchPlayedMins = 0;
	}

	$outputTableBegin = " <tr class=\"dates\"> ";
	$outputTableBegin .= " <td>«··«⁄»</td>\n";
	$outputTableBegin .= " <td>·⁄»</td>\n";
	$outputTableBegin .= " <td>«”«”Ì</td>\n";
	$outputTableBegin .= " <td>»œÌ·</td>\n";
	$outputTableBegin .= " <td>œﬁ«∆ﬁ</td>\n";
	$outputTableBegin .= "</tr>\n";
	$outputTableBegin .= "";

	$sqlTblStanding = "SELECT * FROM Minutes ORDER BY minutes DESC,played DESC,sub DESC";
	$queryresultTblStanding = mysql_query($sqlTblStanding)
		or die(mysql_error());
	$NewTr = 1;
	while($rowTbl = mysql_fetch_assoc($queryresultTblStanding)){
		$playerID = $rowTbl['player'];
		$played = $rowTbl['played'];
		$linedUp = $rowTbl['linedUp'];
		$sub = $rowTbl['sub'];
		$minutes = $rowTbl['minutes'];

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
		$outputTable .= "<td class=\"whiteBorder\"> $played </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $linedUp </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $sub </td>";
		$outputTable .= "<td class=\"whiteBorder\"> $minutes </td>";
		$outputTable .= "</tr>";
		$NewTr ++ ;
	}
	echo $outputTableBegin;
	echo $outputTable;
	echo "</table>";
	mysql_free_result($queryresultMatch);
}

echo "</table>\n";

// making footer
echo makeFooterSimple();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
include 'db_conn.php';
require_once('AFunctions.php');

if (isset($_GET['LinedUp'])) {
	$matchIDGet = $_GET["LinedUp"];
	$teamIDGet = $_GET["teamID"];

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$season = $rowMatch['matchSeason'];
	echo "<select name=\"OwnGoal\" size=\"11\" onclick=\"CityExFile('getPlayerCheck.php','playerIDSub',this.value,'playerCxBxSub')\">";
	$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=0 OR inmatchType=5)
	ORDER BY inmatchPosition,inmatchNumber";
	$queryresultInMatch = mysql_query($sqlInMatch)
	or die(mysql_error());
	if (mysql_num_rows($queryresultInMatch) != 0) {
		while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
			$PlayerInMatch = $rowInMatch['inmatchMember'];
			$PlayerNumber = $rowInMatch['inmatchNumber'];
			echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
			echo playerShortNameAr($PlayerInMatch);
			echo "</option>";

		}
	} else {
		$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$teamIDGet' AND inseasonType=0 AND inseasonTransfer=0";
		$queryresultSeason = mysql_query($sqlInSeason)
			or die(mysql_error());
		while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
			$PlayerInSeason = $rowInSeason['inseasonMember'];
			echo "	<option value=\"$PlayerInSeason\"> ";
			echo playerShortNameAr($PlayerInSeason);
			echo "</option>";
		}
	}
	mysql_close($conn);
	echo "</select>";
}

elseif (isset($_GET["playerID"])) {
	$playerIDGet = $_GET["playerID"];
	$sqlcity = "SELECT * FROM players WHERE playerID='$playerIDGet'";
	$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
	while ($rowCity = mysql_fetch_assoc($queryresultcity)) {
		$playerID = $rowCity['playerID'];
		$firstNameAr = $rowCity['playerFirstNameAr'];
		$MidNameAr = $rowCity['playerMidNameAr'];
		$lastNameAr = $rowCity['playerLastNameAr'];
		echo "<fieldset id=\"playerChxBx\">";
		echo "<input type=\"checkbox\" checked=\"checked\" onclick=\"HideDiv('playerChxBx')\" name=\"playerOne\" value=\"$playerID\"> $firstNameAr $MidNameAr $lastNameAr\n";
		echo "</fieldset>";
	}

	mysql_free_result($queryresultcity);
	mysql_close($conn);
}

elseif (isset($_GET["playerIDSub"])) {
	$playerIDGet = $_GET["playerIDSub"];
	$sqlcity = "SELECT * FROM players WHERE playerID='$playerIDGet'";
	$queryresultcity = mysql_query($sqlcity)
			or die(mysql_error());
	while ($rowCity = mysql_fetch_assoc($queryresultcity)) {
		$playerID = $rowCity['playerID'];
		$firstNameAr = $rowCity['playerFirstNameAr'];
		$MidNameAr = $rowCity['playerMidNameAr'];
		$lastNameAr = $rowCity['playerLastNameAr'];
		echo "<fieldset id=\"playerChxBxSub\">";
		echo "<input type=\"checkbox\" checked=\"checked\" onclick=\"HideDiv('playerChxBxSub')\" name=\"playerTwo\" value=\"$playerID\"> $firstNameAr $MidNameAr $lastNameAr\n";
		echo "</fieldset>";
	}

	mysql_free_result($queryresultcity);
	mysql_close($conn);
}

elseif (isset($_GET['Subs'])) {
	$matchIDGet = $_GET["Subs"];
	$teamIDGet = $_GET["teamID"];

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$season = $rowMatch['matchSeason'];

	echo "<select name=\"PlayersSubs\" size=\"7\" onclick=\"CityExFile('getPlayerCheck.php','playerIDSub',this.value,'playerCxBxSub')\">";
	$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=1
	ORDER BY inmatchPosition,inmatchNumber";
	$queryresultInMatch = mysql_query($sqlInMatch)
		or die(mysql_error());
	if (mysql_num_rows($queryresultInMatch) != 0) {
		while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
			$PlayerInMatch = $rowInMatch['inmatchMember'];
			$PlayerNumber = $rowInMatch['inmatchNumber'];
			echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
			echo playerShortNameAr($PlayerInMatch);
			echo "</option>";

		}
	} else {
		$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$teamIDGet' AND inseasonType=0 AND inseasonTransfer=0";
		$queryresultSeason = mysql_query($sqlInSeason)
			or die(mysql_error());
		while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
			$PlayerInSeason = $rowInSeason['inseasonMember'];
			echo "	<option value=\"$PlayerInSeason\"> ";
			echo playerShortNameAr($PlayerInSeason);
			echo "</option>";
		}
	}
	mysql_close($conn);
	echo "</select>";
}

elseif (isset($_GET['assist'])) {
	$matchIDGet = $_GET["assist"];
	$teamIDGet = $_GET["teamID"];

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$season = $rowMatch['matchSeason'];
	echo "<select name=\"PlayersAssist\" size=\"11\" onclick=\"CityExFile('getPlayerCheck.php','playerIDSub',this.value,'playerCxBxSub')\">";
	$sqlInMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=0 OR inmatchType=5)
	ORDER BY inmatchPosition,inmatchNumber";
	$queryresultInMatch = mysql_query($sqlInMatch)
	or die(mysql_error());
	if (mysql_num_rows($queryresultInMatch) != 0) {
		while ($rowInMatch = mysql_fetch_assoc($queryresultInMatch)) {
			$PlayerInMatch = $rowInMatch['inmatchMember'];
			$PlayerNumber = $rowInMatch['inmatchNumber'];
			echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
			echo playerShortNameAr($PlayerInMatch);
			echo "</option>";

		}
	} else {
		$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$teamIDGet' AND inseasonType=0 AND inseasonTransfer=0";
		$queryresultSeason = mysql_query($sqlInSeason)
			or die(mysql_error());
		while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
			$PlayerInSeason = $rowInSeason['inseasonMember'];
			echo "	<option value=\"$PlayerInSeason\"> ";
			echo playerShortNameAr($PlayerInSeason);
			echo "</option>";
		}
	}
	mysql_close($conn);
	echo "</select>";
}

elseif (isset($_GET['botton']) && isset($_GET['match'])) {
	$InsertMatch = $_GET["botton"];
	$matchIDGet = $_GET["match"];
	if ($InsertMatch == "startmatch") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','0','1');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "بدأت المباراة";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','end1st','matchBotton')\" value=\"انتهى الشوط الأول\">";
	}
	elseif ($InsertMatch == "end1st") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','45','2');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "إنتهى الشوط الأول";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','start2nd','matchBotton')\" value=\"بدأ الشوط الثاني\">";
	}
	elseif ($InsertMatch == "start2nd") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','46','3');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "بدأ الشوط الثاني";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endMatch','matchBotton')\" value=\"انتهت المباراة\">";
	}
	elseif ($InsertMatch == "end2nd") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','90','4');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهى الشوط الثاني";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartEx1st','matchBotton')\" value=\"بدأ الشوط الإضافي الأول\">";
	}
	elseif ($InsertMatch == "StartEx1st") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','91','5');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "بدأ الشوط الإضافي الاول";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','endEx1st','matchBotton')\" value=\"انتهى الشوط الإضافي الأول\">";
	}
	elseif ($InsertMatch == "endEx1st") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','105','6');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهى الشوط الإضافي الأول";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartEx2nd','matchBotton')\" value=\"بدأ الشوط الإضافي الثاني\">";
	}
	elseif ($InsertMatch == "StartEx2nd") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','106','7');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "بدأ الشوط الإضافي الثاني";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','EndEx2nd','matchBotton')\" value=\"انتهى الشوط الإضافي الثاني\">";
	}
	elseif ($InsertMatch == "EndEx2nd") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','120','8');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهى الشوط الإضافي الثاني";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','StartPenalty','matchBotton')\" value=\"بدأت ضربات الترجيح\">";
	}
	elseif ($InsertMatch == "endMatchEx") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','120','9');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهت المباراة";
	}
	elseif ($InsertMatch == "StartPenalty") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','125','10');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "بدأت ضربات الترجيح";
		echo "<input type=\"button\" onclick=\"CityExFile('getPlayerCheck.php','match=$matchIDGet&botton','EndPenalty','matchBotton')\" value=\"انتهت ضربات الترجيح\">";
	}
	elseif ($InsertMatch == "EndPenalty") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','130','11');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهت ضربات الترجيح";
	}
	elseif ($InsertMatch == "endMatch") {
		$sqlMatchAnalysis = "INSERT INTO matchanalysis (`analysisMatch`,`analysisTeam`,`analysisPlayer`,`analysisEvent`,`analysisHalf`,`analysisMins`,`analysisComment`)
			VALUES ('$matchIDGet','0','0','0','0','90','9');";
		mysql_query($sqlMatchAnalysis) or die (mysql_error());
		echo "انتهت المباراة";
	}
}

elseif (isset($_GET['Submission']) && isset($_GET["match"])) {

	$matchIDGet = $_GET["match"];
	/// check if the Comp is league or Cup
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$teamHome = $rowMatch['matchTeamHome'];
	$teamAway = $rowMatch['matchTeamAway'];
	$Comp = $rowMatch['matchComp'];
	$season = $rowMatch['matchSeason'];
	$round = $rowMatch['matchRound'];
	$group = $rowMatch['matchGroup'];

	$sqlComp = "SELECT * FROM competition WHERE compID='$Comp'";
	$queryresultComp = mysql_query($sqlComp)
		or die(mysql_error());
	$rowComp = mysql_fetch_assoc($queryresultComp);
	$CompSys = $rowComp['compSys'];
	// finish checking
	// check the result to give an extra time or no
	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisMatch='$matchIDGet'";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
	or die(mysql_error());
	$result1 = 0;
	$result2 = 0;
	$penaltiesTeam1 = 0;
	$penaltiesTeam2 = 0;
	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$Mins = $rowMatchAnalysis['analysisMins'];
		$half = $rowMatchAnalysis['analysisHalf'];
		$team = $rowMatchAnalysis['analysisTeam'];
		$analysEvent = $rowMatchAnalysis['analysisEvent'];
		if ($analysEvent == 2 && ($half == 1 OR $half == 2 OR $half == 3 OR $half == 4)) {
			if ($team == $teamHome) {
				$result1 ++;
			}
			elseif ($team == $teamAway) {
				$result2 ++;
			}
		}
		elseif ($analysEvent == 2 && $half == 5) {
			if ($team == $teamHome) {
				$penaltiesTeam1 ++;
			}
			elseif ($team == $teamAway) {
				$penaltiesTeam2 ++;
			}
		}
	}
	$sqlMatch2 = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$round'
		AND matchGroup='$group' AND matchTeamHome='$teamAway' AND matchTeamAway='$teamHome'";
	$queryresultMatch2 = mysql_query($sqlMatch2)
	or die(mysql_error());
	$rowMatch2 = mysql_num_rows($queryresultMatch2);
	$matchNextRound = $round / 2;
	if ($rowMatch2 == 0) {
		if ($result1 < $result2) {
			$winnerTeam = $teamAway;
		}
		elseif ($result1 > $result2) {
			$winnerTeam = $teamHome;
		}
		else {
			if ($penaltiesTeam1 < $penaltiesTeam2) {
				$winnerTeam = $teamAway;
			}
			elseif ($penaltiesTeam1 > $penaltiesTeam2) {
				$winnerTeam = $teamHome;
			}
		}
		switch($group){
			case 1:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='1'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 2:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='1'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 3:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='2'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 4:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='2'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 5:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='3'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 6:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='3'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 7:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamHome='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='4'";
				mysql_query($sql) or die (mysql_error());
				break;
			case 8:
				$sql = "UPDATE `matchcenter`.`match` SET matchTeamAway='$winnerTeam'
		WHERE matchSeason='$season' AND matchComp='$Comp' AND matchRound='$matchNextRound'
		AND matchGroup='4'";
				mysql_query($sql) or die (mysql_error());
				break;
		} // switch
	}
	else {
		$rowMatch2 = mysql_fetch_assoc($queryresultMatch2);
		$SecondMatch = $rowMatch2['matchID'];
		// for the second leg check if it's played or no

	}
}

elseif (isset($_GET['editAnalysis'])) {
	$AnalysisID = $_GET['editAnalysis'];
	echo "<table  class=\"mcenter\">\n";

	$sqlMatchAnalysis = "SELECT * FROM matchanalysis WHERE analysisID='$AnalysisID'";
	$queryresultMatchAnalysis = mysql_query($sqlMatchAnalysis)
		or die(mysql_error());
	while($rowMatchAnalysis = mysql_fetch_assoc($queryresultMatchAnalysis)){
		$match = $rowMatchAnalysis['analysisMatch'];
		$Team = $rowMatchAnalysis['analysisTeam'];
		$Player = $rowMatchAnalysis['analysisPlayer'];
		$Event = $rowMatchAnalysis['analysisEvent'];
		$Penalty = $rowMatchAnalysis['analysisPenalty'];
		$Min = $rowMatchAnalysis['analysisMins'];
		$half = $rowMatchAnalysis['analysisHalf'];
		$comment = $rowMatchAnalysis['analysisComment'];


		$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$match'";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		$rowMatch = mysql_fetch_assoc($queryresultMatch);
		$season = $rowMatch['matchSeason'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$Comp = $rowMatch['matchComp'];
		$sqlComp = "SELECT * FROM competition WHERE compID='$Comp'";
		$queryresultComp = mysql_query($sqlComp)
			or die(mysql_error());
		$rowComp = mysql_fetch_assoc($queryresultComp);
		$CompSys = $rowComp['compSys'];

		echo "<tr><td>\n";
		echo "الفريق";
		echo "</td>\n";
		echo "<td>\n";
		if ($Team == $team1) {
			echo "<input type=\"radio\" checked=\"checked\" name=\"teamsPlaying\" value=\"$team1\">";
			echo teamNameAr($team1);
			echo "<input type=\"radio\" name=\"teamsPlaying\" value=\"$team2\">";
			echo teamNameAr($team2);
		}
		elseif ($Team == $team2) {
			echo "<input type=\"radio\" name=\"teamsPlaying\" value=\"$team1\">";
			echo teamNameAr($team1);
			echo "<input type=\"radio\" checked=\"checked\" name=\"teamsPlaying\" value=\"$team2\">";
			echo teamNameAr($team2);
		}
		echo "</td></tr>\n";
		mysql_free_result($queryresultMatch);

		echo "<tr><td>\n";
		echo "";
		echo "</td>\n<td>";
		echo "<div id=\"PlayersNames\">";
		echo "<select name=\"players\">";
		echo "	<option value=\"0\"> </option>";
		$sqlMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$match' AND inmatchTeam='$Team' AND (inmatchType=0 OR inmatchType=1
		OR inmatchType=5 OR inmatchType=6) ORDER BY inmatchNumber";
		$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
		if (mysql_num_rows($queryresultMatch) != 0) {
			while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
				$PlayerInMatch = $rowMatch['inmatchMember'];
				$PlayerNumber = $rowMatch['inmatchNumber'];
				if ($Player == $PlayerInMatch) {
					echo "	<option selected=\"selected\" value=\"$PlayerInMatch\">$PlayerNumber - ";
				} else {
					echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
				}
				echo playerShortNameAr($PlayerInMatch);
				echo "</option>";

			}
			mysql_free_result($queryresultMatch);
		} else {
			$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$Team' AND inseasonType=0 AND inseasonTransfer=0";
			$queryresultSeason = mysql_query($sqlInSeason)
				or die(mysql_error());
			while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
				$PlayerInSeason = $rowInSeason['inseasonMember'];
				if ($Player == $PlayerInSeason) {
					echo "	<option selected=\"selected\" value=\"$PlayerInSeason\">";
				} else {
					echo "	<option value=\"$PlayerInSeason\">";
				}
				echo playerShortNameAr($PlayerInSeason);
				echo "</option>";
			}
			mysql_free_result($queryresultMatch);
		}
		echo "</select>";
		echo "</div>";
		echo "</td>\n</tr>";

		echo "<tr><td>\n";
		echo "</td>\n";
		echo "<td>\n الشوط";
		echo "<select name=\"half\" id=\"half\">";
		for ($i=0; $i <= 4; $i++){
			switch($i){
				case 1:
					$halfName = "الشوط الأول";
					break;
				case 2:
					$halfName = "الشوط الثاني";
					break;
				case 3:
					$halfName = "الشوط الإضافي الأول";
					break;
				case 4:
					$halfName = "الشوط الإضافي الثاني";
					break;
				case 0:
					$halfName = " الإستراحه";
					break;
			} // switch
			if ($i == $half) {
				echo "	<option selected=\"selected\" value=\"$i\">$halfName</option>";
			} else {
				echo "	<option value=\"$i\">$halfName</option>";
			}
		}
		echo "</select>";
		echo "</td>\n</tr>";

		echo "<tr><td>\n";
		echo "</td>\n";
		echo "<td>\n الدقيقة";
		echo "<select name=\"mins\" id=\"mins\">";
		if ($CompSys == 0) {
			for ($i=1; $i <= 90; $i++){
				if ($i == $Min) {
					echo "	<option selected=\"selected\" value=\"$i\">$i</option>";
				} else {
					echo "	<option value=\"$i\">$i</option>";
				}
			}
		} else {
			for ($i=1; $i <= 120; $i++){
				if ($i == $Min) {
					echo "	<option selected=\"selected\" value=\"$i\">$i</option>";
				} else {
					echo "	<option value=\"$i\">$i</option>";
				}
			}
		}
		echo "</select>";
		echo "</td>\n</tr>";
		echo "<tr><td>\n";
		echo "</td>\n";
		echo " <td>\n | ";
		global $EventSimpleLiveAr;
		for ($i=0; $i < sizeof($EventSimpleLiveAr); $i++){
			if ($i == $Event) {
				echo "<input type=\"radio\" checked=\"checked\" name=\"event\" value=\"$i\">".$EventSimpleLiveAr[$i]." | ";
			}
			elseif ($i == 6) {
				echo "<br>";
			}
			else {
				echo "<input type=\"radio\" name=\"event\" value=\"$i\">".$EventSimpleLiveAr[$i]." | ";
			}
		}
		global $PenaltiesAr;
		for ($i = 0; $i < sizeof($PenaltiesAr); $i++){
			if ($i == 0) {
				echo "<input type=\"radio\" checked=\"checked\" name=\"penalty\" value=\"$i\"> ليست ضربة جزاء | ";
			} else {
				if ($i == $Penalty) {
					echo "<input type=\"radio\" checked=\"checked\" name=\"penalty\" value=\"$i\">".$PenaltiesAr[$i]." | ";
				}
				else {
					echo "<input type=\"radio\" name=\"penalty\" value=\"$i\">".$PenaltiesAr[$i]." | ";
				}
			}
		}
		echo "<br>";
		echo "<br>";
		if ($Team == $team1) {
			echo "<input type=\"radio\" name=\"penalty\" value=\"5\" onclick=\"CityExFile('getPlayerCheck.php','season=$season&team=$team2&editAnalysisPlayers','".$match."','PlayersNames');\"> هدف عكسي |";
		}
		else {
			echo "<input type=\"radio\" name=\"penalty\" value=\"5\" onclick=\"CityExFile('getPlayerCheck.php','season=$season&team=$team1&editAnalysisPlayers','".$match."','PlayersNames');\"> هدف عكسي |";
		}
		echo "</td>\n</tr>";
	}
	echo "</table";
}

elseif (isset($_GET['editAnalysisPlayers'])) {
	$Team = $_GET['team'];
	$match = $_GET['editAnalysisPlayers'];
	$season = $_GET['season'];

	echo "<select name=\"players\">";
	echo "	<option value=\"0\"> </option>";
	$sqlMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$match' AND inmatchTeam='$Team' AND (inmatchType=0 OR inmatchType=1
		OR inmatchType=5 OR inmatchType=6) ORDER BY inmatchNumber";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	if (mysql_num_rows($queryresultMatch) != 0) {
		while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
			$PlayerInMatch = $rowMatch['inmatchMember'];
			$PlayerNumber = $rowMatch['inmatchNumber'];
			if ($Player == $PlayerInMatch) {
				echo "	<option selected=\"selected\" value=\"$PlayerInMatch\">$PlayerNumber - ";
			} else {
				echo "	<option value=\"$PlayerInMatch\">$PlayerNumber - ";
			}
			echo playerShortNameAr($PlayerInMatch);
			echo "</option>";

		}
		mysql_free_result($queryresultMatch);
	} else {
		$sqlInSeason = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$Team' AND inseasonType=0 AND inseasonTransfer=0";
		$queryresultSeason = mysql_query($sqlInSeason)
			or die(mysql_error());
		while ($rowInSeason = mysql_fetch_assoc($queryresultSeason)) {
			$PlayerInSeason = $rowInSeason['inseasonMember'];
			if ($Player == $PlayerInSeason) {
				echo "	<option selected=\"selected\" value=\"$PlayerInSeason\">";
			} else {
				echo "	<option value=\"$PlayerInSeason\">";
			}
			echo playerShortNameAr($PlayerInSeason);
			echo "</option>";
		}
		mysql_free_result($queryresultMatch);
	}
	echo "</select>";
}

elseif (isset($_GET['editComment'])) {
	$CommentID = $_GET['editComment'];
	echo "<table  class=\"mcenter\">\n";
	$sqlComment = "SELECT * FROM comment WHERE commentID='$CommentID'";
	$queryresultComment = mysql_query($sqlComment)
		or die(mysql_error());
	while($rowComment = mysql_fetch_assoc($queryresultComment)){
		$comment = $rowComment['commentText'];
		echo "<textarea rows=\"7\" style=\"width:90%;\" type=\"text\" name=\"commentPost\" id=\"commentPost\">$comment</textarea>";
	}
}
?>
	</body>
</html>
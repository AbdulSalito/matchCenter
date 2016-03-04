<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add in match");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"addClub\" action = \"\" method = \"post\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈÷«›… ≈·Ï „»«—«…</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["match"]) && isset($_GET["type"])) {
	$matchIDGet = $_GET["match"];
	$teamIDGet = $_GET["team"];
	$TypIDGet = $_GET["type"];

	$postAction .= "match=";
	$postAction .= $matchIDGet;
	$postAction .= "&team=";
	$postAction .= $teamIDGet;
	$postAction .= "&type=";
	$postAction .= $TypIDGet;

	echo "<form id = \"addClub\" action = \"addInMatch.php?$postAction\" method = \"post\">\n";
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„»«—«…</td>\n";
	echo "	<td>\n";
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	$MatchSeason = $rowMatch['matchSeason'];
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];

	$sqlSesMatch = "SELECT * FROM season WHERE seasonID='$MatchSeason'";
	$queryresultSesMatch = mysql_query($sqlSesMatch)
	or die(mysql_error());
	$rowSesMatch = mysql_fetch_assoc($queryresultSesMatch);
	$seasonStart = $rowSesMatch['seasonYearStart'];
	mysql_free_result($queryresultSesMatch);
	$seasonStart =  strtotime($seasonStart);
	$dateCompStart = date("Y",$seasonStart)."-07-01";
	//$dateCompStart = strtotime($dateCompStart);
	$dateCompStart = date("Y-m-d",strtotime($dateCompStart));
	if ($dateMatch < $dateCompStart) {
		$dateCompStart = strtotime($dateCompStart);
		$dateStarting = date("Y",$dateCompStart);
		$dateStarting --;
		$dateFinishin = date("Y",$dateCompStart);
	}
	elseif ($dateMatch > $dateCompStart) {
		$dateCompStart = strtotime($dateCompStart);
		$dateStarting = date("Y",$dateCompStart);
		$dateFinishin = date("Y",$dateCompStart);
		$dateFinishin ++;
	}
	$sqlSes = "SELECT * FROM season WHERE seasonYearStart='$dateStarting' AND seasonYearEnd='$dateFinishin'";
	$queryresultSes = mysql_query($sqlSes)
		or die(mysql_error());
	$rowSes = mysql_fetch_assoc($queryresultSes);
	$seasonIDGet = $rowSes['seasonID'];
	mysql_free_result($queryresultSes);

	$outputTable = "<table>";
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";

	$outputTable .= "<td>".teamNameAr($team1)."</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>".teamNameAr($team2)."</td>";
	$outputTable .= "</tr></table>";
	echo $outputTable;
	mysql_free_result($queryresultMatch);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	global $matchTypeAr;
	echo "$matchTypeAr[$TypIDGet]";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n  «·√⁄÷«¡";
	echo " </td>\n";
	echo "	<td>\n";
	echo "<table  class=\"player\">\n";
	echo "<tr>";
	$redirectAction = "addInMatch.php?";
	$redirectAction .= "match=";
	$redirectAction .= $matchIDGet;
	$redirectAction .= "&team=";
	$redirectAction .= $teamIDGet;
	$redirectAction .= "&type=";
	if ($TypIDGet == 0) {
		// check if players Already have been added
		$sqlInMatchCheck = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=0 OR inmatchType=6)";
		$queryresultInMatchCheck = mysql_query($sqlInMatchCheck)
			or die(mysql_error());
		$rowsNum = mysql_num_rows($queryresultInMatchCheck);
		if ($rowsNum == 11) {
			$TypIDGetPlus = $TypIDGet + 1;
			$redirectAction .= $TypIDGetPlus;
			header("location: $redirectAction") ;
		}
		$selectedLimit = 11 - $rowsNum;
		echo selectedLimit($selectedLimit);
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=0
		AND inseasonTransfer=0  ORDER BY inseasonMember";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$PlayerInSes = $rowInSes['inseasonMember'];
			$sqlPlayer = "SELECT * FROM players WHERE playerID='$PlayerInSes'";
				$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$playerID = $rowPlayer['playerID'];
			$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
			$PlayerNum = $rowPlayer['playerNum'];
			$PlayerPos = $rowPlayer['playerPosition'];
			echo "</tr><tr id=\"$playerID\"><td><input type=\"checkbox\"  onclick=\"setChecks(this);hightLight(this,'$playerID');\" name=\"players[]\" value=\"$playerID\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</td>";
			echo "<td>";
			$outputPn = "<select name = \"$playerID\" id =\"$playerID\">";
			$outputPn .= "<option value=\"\"> </option>\n";
			for( $i = 1 ; $i < 100 ; $i++){
				if ($PlayerNum == $i) {
					$outputPn .= "<option value=\"$i\" selected=\"selected\">$i</option>\n";
				}
				$outputPn .= "<option value=\"$i\">$i</option>\n";
			}
			$outputPn .="</select>";
			echo $outputPn;
			echo "</td>";
			echo "<td>";
			Global $positionAr;
			echo "<select name = \"Pos$playerID\" id =\"Pos$playerID\">";
			for( $i = 0 ; $i < sizeof($positionAr) ; $i++){
				if ($PlayerPos == $i) {
					echo "<option value=\"$i\" selected=\"selected\">".$positionAr[$i]."</option>\n";
				}
				echo "<option value=\"$i\">".$positionAr[$i]."</option>\n";
			}
			echo "</select>";
			echo "</td>";
		}

	mysql_free_result($queryresultInSes);
	}

	elseif ($TypIDGet == 1) {
		// check if players Already have been added
		$sqlInMatchCheck = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=1 OR inmatchType=5)";
		$queryresultInMatchCheck = mysql_query($sqlInMatchCheck)
			or die(mysql_error());
		$rowsNum = mysql_num_rows($queryresultInMatchCheck);
		if ($rowsNum == 7) {
			$TypIDGetPlus = $TypIDGet + 1;
			$redirectAction .= $TypIDGetPlus;
			header("location: $redirectAction") ;
		}
		$selectedLimit = 7 - $rowsNum;
		echo selectedLimit($selectedLimit);
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=0";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$sqlInMatch = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=0 OR
		inmatchType=1 OR inmatchType=5 OR inmatchType=6)";
		$queryresultInMatch = mysql_query($sqlInMatch)
			or die(mysql_error());
		//while () {
		$arrayInSes = array();
		$arrayInMatch = array();
		while($rowInSes = mysql_fetch_assoc($queryresultInSes)){
			$PlayerInSes = $rowInSes['inseasonMember'];
			array_push($arrayInSes, "$PlayerInSes");
		}
		while($rowInMatch = mysql_fetch_assoc($queryresultInMatch)){
			$playerInMatch = $rowInMatch['inmatchMember'];
			array_push($arrayInMatch, "$playerInMatch");
		}
		$SubsPlayer = array_diff($arrayInSes,$arrayInMatch);
		$SubsPlayerResoeted = array_values($SubsPlayer);
		for ( $iFor = 0 ; $iFor < sizeof($SubsPlayerResoeted);$iFor++) {
			$playerIDLook = $SubsPlayerResoeted[$iFor];
			$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerIDLook'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$playerID = $rowPlayer['playerID'];
			$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
			$PlayerNum = $rowPlayer['playerNum'];
			$PlayerPos = $rowPlayer['playerPosition'];
			echo "</tr><tr id=\"$playerID\"><td><input type=\"checkbox\"  onclick=\"setChecks(this);hightLight(this,'$playerID');\" name=\"players[]\" value=\"$playerID\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</td>";
			echo "<td>";
			echo "<select name = \"$playerID\" id =\"$playerID\">";
			echo "<option value=\"\"> </option>\n";
			for( $i = 1 ; $i < 100 ; $i++){
				if ($PlayerNum == $i) {
					echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";
				}
				echo "<option value=\"$i\">$i</option>\n";
			}
			echo "</select>";
			echo "</td>";
			echo "<td>";
			Global $positionAr;
			echo "<select name = \"Pos$playerID\" id =\"Pos$playerID\">";
			for( $i = 0 ; $i < sizeof($positionAr) ; $i++){
				if ($PlayerPos == $i) {
					echo "<option value=\"$i\" selected=\"selected\">".$positionAr[$i]."</option>\n";
				}
				echo "<option value=\"$i\">".$positionAr[$i]."</option>\n";
			}
			echo "</select>";
			echo "</td>";
		}
		mysql_free_result($queryresultInSes);
	//	mysql_free_result($queryresultPlayer);
		mysql_free_result($queryresultInMatch);

	}

	elseif ($TypIDGet == 2) {
		// check if players Already have been added
		$sqlInMatchCheck = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=2";
		$queryresultInMatchCheck = mysql_query($sqlInMatchCheck)
			or die(mysql_error());
		$rowsNum = mysql_num_rows($queryresultInMatchCheck);
		if ($rowsNum == 1) {
			$TypIDGetPlus = $TypIDGet + 1;
			$redirectAction .= $TypIDGetPlus;
			header("location: $redirectAction") ;
		}
		$i = 0;
		echo selectedLimit(1);
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=1";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$memberInSes = $rowInSes['inseasonMember'];
			$sql = "SELECT * FROM managers WHERE managerID='$memberInSes'";
			$queryresult = mysql_query($sql)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresult);
			$playerID = $rowPlayer['managerID'];
			$PlayerFirstNameAr = $rowPlayer['managerFirstNameAr'];
			$PlayerLastNameAr = $rowPlayer['managerLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"checkbox\"  onclick=\"setChecks(this)\" name=\"players[]\" value=\"$playerID\"> $PlayerFirstNameAr $PlayerLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresult);
		mysql_free_result($queryresultInSes);
	}

	elseif ($TypIDGet == 3 || $TypIDGet == 4) {
		// check if players Already have been added
		$sqlInMatchCheck = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=3 OR inmatchType=4)";
		$queryresultInMatchCheck = mysql_query($sqlInMatchCheck)
			or die(mysql_error());
		$rowsNum = mysql_num_rows($queryresultInMatchCheck);
		if ($rowsNum == 2) {
			$redirectAction = "addMatchAnalysis.php?";
			$redirectAction .= "match=";
			$redirectAction .= $matchIDGet;
			header("location: $redirectAction") ;
		}
		$i = 0;
		echo selectedLimit(1);
		include 'db_conn.php';
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=2";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$memberInSes = $rowInSes['inseasonMember'];
		$sqlChairman = "SELECT * FROM  chairmen WHERE  chairmanID='$memberInSes'";
		$queryresultChairman = mysql_query($sqlChairman)
			or die(mysql_error());
			$rowChairman = mysql_fetch_assoc($queryresultChairman);
			$ChairmanID = $rowChairman['chairmanID'];
			$ChairmanFirstNameAr = $rowChairman['chairmanFirstNameAr'];
			$ChairmanLastNameAr = $rowChairman['chairmanLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"checkbox\"  onclick=\"setChecks(this)\" name=\"players[]\" value=\"$ChairmanID\"> $ChairmanFirstNameAr $ChairmanLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresultChairman);
		mysql_free_result($queryresultInSes);
	}

	echo "	</tr>\n";
	echo "</table>\n";
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['players']) && isset($_GET["team"]) && isset($_GET["match"])  && isset($_GET["type"])) {
	include 'db_conn.php';
	$playersPost = $_POST['players'];
	$team = $_GET["team"];
	$match = $_GET["match"];
	$type = $_GET["type"];
	foreach ($playersPost as $players){
		//foreach ($playersNumPost as $playersNum){
			if ($type == 0 || $type == 1) {
				$playersNumPost = $_POST[$players];
				$PosPost = "Pos$players";
				$position = $_POST[$PosPost];
				$sql = "INSERT INTO inmatch (`inmatchMatch`, `inmatchTeam`, `inmatchMember`, `inmatchType`,`inmatchNumber`,`inmatchPosition`)
								VALUES ('$match', '$team', '$players','$type','$playersNumPost','$position');";
				mysql_query($sql) or die (mysql_error());
			}
		//}
		if ($type == 2 || $type == 3 || $type == 4) {
			$sql = "INSERT INTO inmatch (`inmatchMatch`, `inmatchTeam`, `inmatchMember`, `inmatchType`,`inmatchNumber`)
							VALUES ('$match', '$team', '$players', '$type', 0);";
			mysql_query($sql) or die (mysql_error());
		}
	}
	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	if ($type < 4) {
		$TypIDGet ++;
		$redirectAction = "addInMatch.php?";
		$redirectAction .= "match=";
		$redirectAction .= $matchIDGet;
		$redirectAction .= "&team=";
		$redirectAction .= $teamIDGet;
		$redirectAction .= "&type=";
		$redirectAction .= $TypIDGet;
		header("location: $redirectAction") ;
	} else {
		$redirectAction = "addMatchAnalysis.php?";
		$redirectAction .= "match=";
		$redirectAction .= $matchIDGet;
		header("location: $redirectAction") ;
	}
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>
<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("edit in match");
// insert the navigation
echo makeMenu();
$seasonIDGet = "";
function showMatch($matchID){
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchID='$matchID'";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$previousMatchDate = "";
	$TrClass = "";
	$rowMatch = mysql_fetch_assoc($queryresultMatch);
	global $seasonIDGet;
	$seasonIDGet = $rowMatch['matchSeason'];
	$dateMatch = $rowMatch['matchDate'];
	$team1 = $rowMatch['matchTeamHome'];
	$team2 = $rowMatch['matchTeamAway'];
	$outputTable = "<table>";
	$outputTable .= "<tr><td>";
	$dateDayEn = date('l', strtotime($dateMatch));
	$dateArr = array("Saturday"=>"«·”» ","Sunday"=>"«·√Õœ","Monday"=>"«·√À‰Ì‰","Tuesday"=>"«·À·«À«¡","Wednesday"=>"«·√—»⁄«¡","Thursday"=>"«·Œ„Ì”","Friday"=>"«·Ã„⁄…");
	$dateDayAr = $dateArr[$dateDayEn];
	$outputTable .= "$dateDayAr $dateMatch</td>";
	$sqlTeam1 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team1'";
	$sqlTeam2 = "SELECT * FROM `matchcenter`.`teams` WHERE teamID='$team2'";
	$queryresultTeam1 = mysql_query($sqlTeam1)
				or die(mysql_error());
	$queryresultTeam2 = mysql_query($sqlTeam2)
				or die(mysql_error());
	$rowTeam1 = mysql_fetch_assoc($queryresultTeam1);
	$rowTeam2 = mysql_fetch_assoc($queryresultTeam2);

	$outputTable .= "<td>".$rowTeam1['teamNameAr']."</td>";
	$outputTable .= "<td>-</td>";
	$outputTable .= "<td>".$rowTeam2['teamNameAr']."</td>";
	$outputTable .= "</tr></table>";
	return $outputTable;
	mysql_free_result($queryresultMatch);
}

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"editInMatch\" action = \"\" method = \"post\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\">  ⁄œÌ· «·„÷«›Ì‰ ≈·Ï  ‘ﬂÌ·… «·„»«—«…</td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["match"]) && isset($_GET["type"])) {
	$matchIDGet = $_GET["match"];
	$teamIDGet = $_GET["team"];
	$TypIDGet = $_GET["type"];
	echo $beginTable;

	echo "	<tr>\n";
	echo "	<td>«·„»«—«…</td>\n";
	echo "	<td>\n";
	echo showMatch($matchIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n  | ";
	global $matchTypeAr;
	for ($i = 0; $i < (sizeof($matchTypeAr) - 2); $i++) {
		if ($i == $TypIDGet) {
			echo "<input type=\"radio\" checked=\"true\" name=\"type\" onclick=\"window.location='editInMatch.php?match=$matchIDGet&team=$teamIDGet&type='+this.value;\" value=\"$i\">".$matchTypeAr[$i]." | ";
		} else {
			echo "<input type=\"radio\" name=\"type\" onclick=\"window.location='editInMatch.php?match=$matchIDGet&team=$teamIDGet&type='+this.value;\" value=\"$i\">".$matchTypeAr[$i]." | ";
		}
	}
	echo "</td></tr>\n";
	if ($TypIDGet == 0) {
		echo "	<tr>\n";
		echo "	<td>\n  «··«⁄»";
		echo " </td>\n";
		echo "	<td>\n";
		include 'db_conn.php';
		$sqlInSes = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=0";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		echo "<select name = \"PlayerIn\" id =\"PlayerIn\">";
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$PlayerInSes = $rowInSes['inmatchMember'];
			$sqlPlayer = "SELECT * FROM players WHERE playerID='$PlayerInSes'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$playerID = $rowPlayer['playerID'];
			$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
			echo "<option value=\"$playerID\">$PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		echo "</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>\n  «··«⁄» «·»œÌ·";
		echo " </td>\n";
		echo "	<td>\n";
		global $seasonIDGet;
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=0";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$sqlInMatch = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND (inmatchType=0 OR
		inmatchType=6)";
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
		echo "<select name = \"PlayerSub\" id =\"PlayerSub\">";
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
			echo "<option value=\"$playerID\">$PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		mysql_free_result($queryresultInMatch);
	}

	elseif ($TypIDGet == 1) {
		echo "	<tr>\n";
		echo "	<td>\n  «··«⁄»";
		echo " </td>\n";
		echo "	<td>\n";
		include 'db_conn.php';
		$sqlInSes = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=1";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		echo "<select name = \"PlayerIn\" id =\"PlayerIn\">";
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$PlayerInSes = $rowInSes['inmatchMember'];
			$sqlPlayer = "SELECT * FROM players WHERE playerID='$PlayerInSes'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$playerID = $rowPlayer['playerID'];
			$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
			echo "<option value=\"$playerID\">$PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		echo "</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>\n  «··«⁄» «·»œÌ·";
		echo " </td>\n";
		echo "	<td>\n";
		global $seasonIDGet;
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
		echo "<select name = \"PlayerSub\" id =\"PlayerSub\">";
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
			echo "<option value=\"$playerID\">$PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		mysql_free_result($queryresultInMatch);
	}

	elseif ($TypIDGet == 2) {
		echo "	<tr>\n";
		echo "	<td>\n  «·„œ—»";
		echo " </td>\n";
		echo "	<td>\n";
		include 'db_conn.php';
		$sqlInSes = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=2";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		echo "<select name = \"PlayerIn\" id =\"PlayerIn\">";
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$PlayerInSes = $rowInSes['inmatchMember'];
			$sqlPlayer = "SELECT * FROM managers WHERE managerID='$PlayerInSes'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$managerID = $rowPlayer['managerID'];
			$managerFirstNameAr = $rowPlayer['managerFirstNameAr'];
			$managerLastNameAr = $rowPlayer['managerLastNameAr'];
			echo "<option value=\"$managerID\">$managerFirstNameAr $managerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		echo "</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>\n  «·„œ—» «·»œÌ·";
		echo " </td>\n";
		echo "	<td>\n";
		global $seasonIDGet;
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=1";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$sqlInMatch = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND inmatchType=2";
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
		echo "<select name = \"PlayerSub\" id =\"PlayerSub\">";
		for ( $iFor = 0 ; $iFor < sizeof($SubsPlayerResoeted);$iFor++) {
			$playerIDLook = $SubsPlayerResoeted[$iFor];
			$sqlPlayer = "SELECT * FROM managers WHERE managerID='$playerIDLook'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$managerID = $rowPlayer['managerID'];
			$managerFirstNameAr = $rowPlayer['managerFirstNameAr'];
			$managerLastNameAr = $rowPlayer['managerLastNameAr'];
			echo "<option value=\"$managerID\">$managerFirstNameAr $managerLastNameAr</option>\n";		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		mysql_free_result($queryresultInMatch);
	}

	elseif ($TypIDGet == 3 || $TypIDGet == 4) {
		echo "	<tr>\n";
		echo "	<td>\n  «·≈œ«—Ì";
		echo " </td>\n";
		echo "	<td>\n";
		include 'db_conn.php';
		$sqlInSes = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND
		(inmatchType=3 OR inmatchType=4)";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		echo "<select name = \"PlayerIn\" id =\"PlayerIn\">";
		while ($rowInSes = mysql_fetch_assoc($queryresultInSes)) {
			$PlayerInSes = $rowInSes['inmatchMember'];
			$sqlPlayer = "SELECT * FROM chairmen WHERE chairmanID='$PlayerInSes'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$managerID = $rowPlayer['chairmanID'];
			$managerFirstNameAr = $rowPlayer['chairmanFirstNameAr'];
			$managerLastNameAr = $rowPlayer['chairmanLastNameAr'];
			echo "<option value=\"$managerID\">$managerFirstNameAr $managerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		echo "</td></tr>\n";
		echo "	<tr>\n";
		echo "	<td>\n  «·≈œ«—Ì «·»œÌ·";
		echo " </td>\n";
		echo "	<td>\n";
		global $seasonIDGet;
		$sqlInSes = "SELECT inseasonMember FROM inseason WHERE inseasonSeason='$seasonIDGet' AND inseasonTeam='$teamIDGet' AND inseasonType=2";
		$queryresultInSes = mysql_query($sqlInSes)
			or die(mysql_error());
		$sqlInMatch = "SELECT inmatchMember FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamIDGet' AND
		(inmatchType=3 OR inmatchType=4)";
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
		echo "<select name = \"PlayerSub\" id =\"PlayerSub\">";
		for ( $iFor = 0 ; $iFor < sizeof($SubsPlayerResoeted);$iFor++) {
			$playerIDLook = $SubsPlayerResoeted[$iFor];
			$sqlPlayer = "SELECT * FROM chairmen WHERE chairmanID='$playerIDLook'";
			$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
			$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
			$managerID = $rowPlayer['chairmanID'];
			$managerFirstNameAr = $rowPlayer['chairmanFirstNameAr'];
			$managerLastNameAr = $rowPlayer['chairmanLastNameAr'];
			echo "<option value=\"$managerID\">$managerFirstNameAr $managerLastNameAr</option>\n";
		}
		echo "</select>";
		mysql_free_result($queryresultInSes);
		mysql_free_result($queryresultInMatch);
	}

	//echo "	</tr>\n";
	//echo "</table>\n";
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}
elseif (isset($_GET["match"])) {
	$matchIDGet = $_GET["match"];
	$teamIDGet = $_GET["team"];

	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·„»«—«…</td>\n";
	echo "	<td>\n";
	echo showMatch($matchIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	global $matchTypeAr;
	global $matchTypeAr;
	for ($i = 0; $i < (sizeof($matchTypeAr) - 2); $i++) {
		echo "<input type=\"radio\" name=\"type\" onclick=\"window.location='editInMatch.php?match=$matchIDGet&team=$teamIDGet&type='+this.value;\" value=\"$i\">".$matchTypeAr[$i]." | ";
	}
	echo "</td></tr>\n";
}


echo "</table>\n";
echo "</form>\n";

if (isset($_POST['PlayerIn']) && isset($_GET["team"])  && isset($_GET["type"])) {
	include 'db_conn.php';
	$playerIn = $_POST['PlayerIn'];
	$playerSub = $_POST['PlayerSub'];
	$team = $_GET["team"];
	$match = $_GET["match"];
	$type = $_GET["type"];
	include 'db_conn.php';
	$sqlPlayer = "SELECT * FROM players WHERE playerID='$playerSub'";
	$queryresultPlayer = mysql_query($sqlPlayer)
	or die(mysql_error());
	$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
	$PlayerNum = $rowPlayer['playerNum'];

	$sql = "UPDATE inmatch SET inmatchMember='$playerSub',inmatchType='$type', inmatchNumber='$PlayerNum'
		WHERE inmatchType='$type' AND inmatchMatch='$match' AND inmatchTeam='$team' AND inmatchMember='$playerIn'";
	mysql_query($sql) or die (mysql_error());
	echo " „  ⁄œÌ· «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>
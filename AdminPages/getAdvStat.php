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
if (isset($_GET["stat"])) {
	$matchIDGet = $_GET["match"];
	$teamID = $_GET["team"];
	$StatIDGet = $_GET["stat"];
	$playerFieldSet = "";
	$sqlMatch = "SELECT * FROM inmatch WHERE inmatchMatch='$matchIDGet' AND inmatchTeam='$teamID' AND (inmatchType=0 OR inmatchType=5
	OR inmatchType=6) ORDER BY inmatchPosition";
	$queryresultMatch = mysql_query($sqlMatch)
		or die(mysql_error());
	$playerFieldSet = "";
	$GoalKeeper = "";
	$DefencePlayers = "";
	$MidfieldPlayers = "";
	$AttackPlayers = "";
	$previousPos = "";
	echo "<table style=\"text-align:ceter;\">\n";
	echo "<tr>\n";
	$AddTr = 0;
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$PlayerInMatch = $rowMatch['inmatchMember'];
		$PlayerNumber = $rowMatch['inmatchNumber'];
		$playerPosition = $rowMatch['inmatchPosition'];
		/*$sqlPlayer = "SELECT * FROM players WHERE playerID='$PlayerInMatch'";
		$queryresultPlayer = mysql_query($sqlPlayer)
				or die(mysql_error());
		$rowPlayer = mysql_fetch_assoc($queryresultPlayer);
		$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
		$PlayerlastNameAr = $rowPlayer['playerLastNameAr'];
		$playerPosition = $rowPlayer['playerPosition'];*/
		if ($AddTr == 2) {
			$playerFieldSet .= "</tr><tr>";
			$AddTr = 0;
		}
		if ($previousPos == $playerPosition) {
			$AddTr++;
		}
		$previousPos = $playerPosition;
		$companationID = "$PlayerInMatch";
		$playerFieldSet .= "<td><fieldset id=\"$PlayerInMatch\">";
		$playerFieldSet .= "<legend>".playerShortNameAr($PlayerInMatch)."</legend>";
		switch($StatIDGet){
			case 0:
				global $EventShotAr;
				for ($i = 0; $i < sizeof($EventShotAr); $i++) {
					$companationID .= "0$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','0$i', '$companationID')\" value=\"".$EventShotAr[$i]."\"/><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			case 1:
				global $EventfoulAr;
				for ($i = 0; $i < sizeof($EventfoulAr); $i++) {
					$companationID .= "1$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','1$i', '$companationID')\" value=\"".$EventfoulAr[$i]."\" /><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			case 2:
				global $EventSetAr;
				for ($i = 0; $i < sizeof($EventSetAr); $i++) {
					$companationID .= "2$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','2$i', '$companationID')\" value=\"".$EventSetAr[$i]."\" /><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			case 3:
				global $EventPassAr;
				for ($i = 0; $i < sizeof($EventPassAr); $i++) {
					$companationID .= "3$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','3$i', '$companationID')\" value=\"".$EventPassAr[$i]."\" /><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			case 4:
				global $EventDefAr;
				for ($i = 0; $i < sizeof($EventDefAr); $i++) {
					$companationID .= "4$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','4$i', '$companationID')\" value=\"".$EventDefAr[$i]."\" /><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			case 5:
				global $EventGKAr;
				for ($i = 0; $i < sizeof($EventGKAr); $i++) {
					$companationID .= "5$i";
					$playerFieldSet .= "<input type=\"button\" onclick=\"addStat('$matchIDGet','$PlayerInMatch','5$i', '$companationID')\" value=\"".$EventGKAr[$i]."\" /><font id=\"$companationID\"></font>\n";
					$playerFieldSet .= "<br>\n";
				}
				break;
			$playerFieldSet .= "</td>";
		} // switch
		$playerFieldSet .= "</fieldset>";
		//$playerFieldSet .= "</fieldset>";
		switch($playerPosition){
			case 4:
			case 5:
				$AttackPlayers .= $playerFieldSet;
				$playerFieldSet = "";
				break;
			case 3:
				$MidfieldPlayers .= $playerFieldSet;
				$playerFieldSet = "";
				break;
			case 1:
			case 2:
				$DefencePlayers .= $playerFieldSet;
				$playerFieldSet = "";
				break;
			case 0:
				$GoalKeeper .= $playerFieldSet;;
				$playerFieldSet = "";
				break;
		} // switch
	}
	echo $GoalKeeper;
	echo "</tr><tr>";
	echo $DefencePlayers;
	echo "</tr><tr>";
	echo $MidfieldPlayers;
	echo "</tr><tr>";
	echo $AttackPlayers;
	mysql_free_result($queryresultMatch);
	echo "</table>\n";
}

elseif (isset($_GET["player"]) && isset($_GET["event"])) {
	$event = $_GET["event"];
	$player = $_GET["player"];
	$match = $_GET["match"];

	$sql = "INSERT INTO `advanceanalysis` (`advMatch`, `advPlayer`, `advEvent`)
					   VALUES ('$match', '$player', '$event');";
	mysql_query($sql) or die (mysql_error());
	$sqlAdv = "SELECT * FROM advanceanalysis WHERE advMatch='$match' AND advPlayer='$player' AND advEvent='$event'";
	$queryresultAdv = mysql_query($sqlAdv)
		or die(mysql_error());
	$rowAdv = mysql_num_rows($queryresultAdv);
	echo $rowAdv;
}
?>
	</body>
</html>
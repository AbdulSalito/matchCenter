<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1256" />
<title>MatchCenter</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/style1.css" />

</head>
<body>
<?php
include 'db_conn.php';
require_once('AFunctions.php');

if (isset($_GET["season"]) && isset($_GET["comp"]) && isset($_GET["roundID"]) && isset($_GET["Group"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["comp"];
	$roundIDGet = $_GET["roundID"];
	echo "<table width=\"100%\">\n";

	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet' AND matchRound='$roundIDGet'";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$i = 0;
	$NumberOfMatches =  mysql_num_rows($queryresultMatch);
	$NumberOfMatches /= 2;
	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$matchID = $rowMatch['matchID'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$matchGroup = $rowMatch['matchGroup'];

		echo "<tr>\n<td width=\"200\">\n";
		echo "<input type=\"checkbox\" checked=\"checked\" name=\"matches[]\" value=\"$matchID\">".TeamNameAr($team1)." - ".TeamNameAr($team2)."\n";
		echo "<td>\n";
		$outputPn = "<select name = \"Group$matchID\" id =\"Group$matchID\" >";
		for($i = 1; $i <= ($NumberOfMatches * 2); $i++){
			if ($matchGroup == $i) {
				$outputPn .= "<option selected=\"selected\" value=\"$i\"> المجموعة $i</option>\n";
			}
			else {
				$outputPn .= "<option value=\"$i\"> المجموعة $i</option>\n";
			}
		}
		$outputPn .="</select>";
		echo $outputPn;
		echo "</td>\n</tr>\n";
	}
	mysql_free_result($queryresultMatch);
	echo "</table>\n</td>";
	mysql_close($conn);
}

elseif (isset($_GET["season"]) && isset($_GET["comp"]) && isset($_GET["roundID"])) {
	$seasonIDGet = $_GET["season"];
	$compIDGet = $_GET["comp"];
	$roundIDGet = $_GET["roundID"];
	echo "<table width=\"100%\">\n";

	if (isset($_GET["GroupNum"])) {
		$GroupNum = $_GET["GroupNum"];
		$whereClause = "matchSeason='$seasonIDGet' AND matchComp='$compIDGet' AND matchRound='$roundIDGet' AND matchGroup='$GroupNum'";
	} else {
		$whereClause = "matchSeason='$seasonIDGet' AND matchComp='$compIDGet' AND matchRound='$roundIDGet'";
	}
	$sqlMatch = "SELECT * FROM `matchcenter`.`match` WHERE $whereClause";
	$queryresultMatch = mysql_query($sqlMatch)
				or die(mysql_error());
	$i = 0;
	$previousTeam = "";

	$sqlMatchRound = "SELECT DISTINCT matchTeamHome FROM `matchcenter`.`match` WHERE matchSeason='$seasonIDGet' AND matchComp='$compIDGet'";
	$queryresultMatchRound = mysql_query($sqlMatchRound)
	or die(mysql_error());
	$NumberOfMatches =  mysql_num_rows($queryresultMatchRound);
	$NumberOfMatches -- ;

	while($rowMatch = mysql_fetch_assoc($queryresultMatch)){
		$matchID = $rowMatch['matchID'];
		$team1 = $rowMatch['matchTeamHome'];
		$team2 = $rowMatch['matchTeamAway'];
		$matchDate = $rowMatch['matchDate'];
		$matchTimeDB = $rowMatch['matchTime'];

		echo "<tr>\n<td width=\"200\">\n";
		echo "<input type=\"checkbox\" checked=\"checked\" name=\"matches[]\" value=\"$matchID\">".TeamNameAr($team1)." - ".TeamNameAr($team2)."\n";
		echo "<td>\n";
		$outputPn = "<select name = \"$matchID\" id =\"$matchID\" class=\"round\">";
		for($i = 1; $i <= ($NumberOfMatches * 2); $i++){
			if ($roundIDGet == $i) {
				$outputPn .= "<option selected=\"selected\" value=\"$i\"> الجولة $i</option>\n";
			}
			else {
				$outputPn .= "<option value=\"$i\"> الجولة $i</option>\n";
			}
		}
		$outputPn .="</select>";
		echo $outputPn;
		echo "</td>\n";
		echo "<td>\n";
		echo "<input type=\"text\" class=\"round\" name=\"date$matchID\" id=\"date$matchID\" value=\"$matchDate\">";
		//echo "<script type=\"text/javascript\" src=\"../DatePicker1.js\"></script>";
		echo "<a href=\"javascript:displayDatePicker('date$matchID');\">";
		echo "<img src=\"../cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Click Here to Pick up the timestamp\"></a>";
		echo "</td>\n";
		echo "<td>\n";
		$outputPn = "<select name = \"time$matchID\" id =\"time$matchID\" class=\"round\">";
		for($iHour = 2; $iHour <= 11; $iHour++){
			switch($iHour){
				case "2":
					$Hour = "02";
					break;
				case "3":
					$Hour = "03";
					break;
				case "4":
					$Hour = "04";
					break;
				case "5":
					$Hour = "05";
					break;
				case "6":
					$Hour = "06";
					break;
				case "7":
					$Hour = "07";
					break;
				case "8":
					$Hour = "08";
					break;
				case "9":
					$Hour = "09";
					break;
				default:
					$Hour = $iHour;
			} // switch
			for($iMins = 0; $iMins < 12; $iMins++){
				$mins = $iMins * 5;
				settype($mins, "string");
				settype($Hour, "string");
				switch($mins){
					case "0":
						$mins = "00";
						break;
					case "5":
						$mins = "05";
				} // switch
				$matchTimeCompare = "$Hour:$mins";
				$matchTime = "$iHour:$mins";
				settype($matchTimeDB, "string");
				if ($matchTimeDB == $matchTimeCompare) {
					$outputPn .= "<option selected=\"selected\" value=\"$matchTimeCompare\">$matchTime pm</option>\n";
				}
				else {
					$outputPn .= "<option value=\"$matchTimeCompare\">$matchTime pm</option>\n";
				}
			}
		}
		$outputPn .="</select>";
		//echo "$matchTime AND $matchTimeDB";
		echo $outputPn;
		echo "</td>\n";
		echo "</td>\n</tr>\n";
		$previousTeam = $team1;
	}
	mysql_free_result($queryresultMatch);
	mysql_free_result($queryresultMatchRound);

	echo "</table>\n</td>";
	mysql_close($conn);
}

elseif (isset($_GET["team1"]) && isset($_GET["team2"]) && isset($_GET["penalties"])) {
	$teamOne = $_GET["team1"];
	$teamTwo = $_GET["team2"];
	echo "<td class=\"whiteBorder\"> <input type=\"text\" name=\"P$teamOne\" class=\"result\"> - <input type=\"text\" name=\"P$teamTwo\" class=\"result\"></td>";

}
?>
	</body>
</html>
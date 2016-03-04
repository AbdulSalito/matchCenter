<?php
	// ask for the functions from it's file
	require_once('AFunctions.php');
include 'db_conn.php';
// insert the header
echo makeHeader("Add Transfer");
// insert the navigation
echo makeMenu();
$postAction = "";

echo "<div id = \"maincontent\">\n";
$beginForm = "<form id = \"addTransfer\" action = \"\" method = \"post\">\n";
$beginTable = "<table  class=\"mcenter\">\n";
$beginTable .= "	<tr class=\"mcenter\">\n";
$beginTable .= "	<td colspan=\"2\"> ≈œ«—… «·«‰ ﬁ«·«  </td>\n";
$beginTable .= "	</tr>\n";

if (isset($_GET["type"]) && isset($_GET["team"])) {
	$TeamIDGet = $_GET["team"];
	$SesTypIDGet = $_GET["type"];
	echo "<form id = \"addTransfer\" action = \"\" method = \"post\">\n";
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	global $SeasonTypeAr;
	echo "$SeasonTypeAr[$SesTypIDGet]";
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·„Ê”„</td>\n";
	echo "	<td>\n <select name = \"season\" id =\"season\">";
	echo "	<option value=\"\"> </option>";
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
	echo "	<td>«·‰«œÌ «·„‰ ﬁ· „‰Â</td>\n";
	echo "	<td>\n";
	echo TeamNameAr($TeamIDGet);
	echo "</td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>\n  «·√⁄÷«¡";
	echo " </td>\n";
	echo "	<td>\n";
	echo "<table  class=\"player\">\n";
	echo "<tr>";
	if ($SesTypIDGet == 0) {
		$i = 0;
		include 'db_conn.php';
		$sqlPlayer = "SELECT * FROM players WHERE playerTeam='$TeamIDGet' ORDER BY playerFirstNameAr";
		$queryresultPlayer = mysql_query($sqlPlayer)
			or die(mysql_error());
		while($rowPlayer = mysql_fetch_assoc($queryresultPlayer)){
			$playerID = $rowPlayer['playerID'];
			$PlayerFirstNameAr = $rowPlayer['playerFirstNameAr'];
			$PlayerMidNameAr = $rowPlayer['playerMidNameAr'];
			$PlayerLastNameAr = $rowPlayer['playerLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"radio\" name=\"players\" value=\"$playerID\"> $PlayerFirstNameAr $PlayerMidNameAr $PlayerLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresultPlayer);
	}
	elseif ($SesTypIDGet == 1) {
		$i = 0;
		include 'db_conn.php';
		$sqlManager = "SELECT * FROM managers WHERE managerTeam='$TeamIDGet' ORDER BY managerFirstNameAr";
		$queryresultManager = mysql_query($sqlManager)
			or die(mysql_error());
		while ($rowManager = mysql_fetch_assoc($queryresultManager)) {
			$managerID = $rowManager['managerID'];
			$managerFirstNameAr = $rowManager['managerFirstNameAr'];
			$managerLastNameAr = $rowManager['managerLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"radio\" name=\"players\" value=\"$managerID\"> $managerFirstNameAr $managerLastNameAr</td>";
			$i ++;
		}

		mysql_free_result($queryresultManager);
	}
	elseif ($SesTypIDGet == 2) {
		$i = 0;
		include 'db_conn.php';
		$sqlChairman = "SELECT * FROM  chairmen WHERE  chairmanTeam='$TeamIDGet' ORDER BY chairmanFirstNameAr";
		$queryresultChairman = mysql_query($sqlChairman)
			or die(mysql_error());
		while ($rowChairman = mysql_fetch_assoc($queryresultChairman)) {
			$ChairmanID = $rowChairman['chairmanID'];
			$ChairmanFirstNameAr = $rowChairman['chairmanFirstNameAr'];
			$ChairmanLastNameAr = $rowChairman['chairmanLastNameAr'];
			if ($i % 3 == 0) {
				echo "</tr><tr>";
			}
			echo "<td><input type=\"radio\" name=\"players\" value=\"$ChairmanID\"> $ChairmanFirstNameAr $ChairmanLastNameAr</td>";
			$i ++;
		}
		mysql_free_result($queryresultChairman);
	}
	echo "	</tr>\n";
	echo "</table>\n";
	echo " </td></tr>\n";
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ «·„‰ ﬁ· „‰Â</td>\n";
	echo "	<td>\n <select name = \"teamTo\" id =\"teamTo\">";
	echo "	<option value=\"\"> </option>";
	$sqlMatch = "SELECT * FROM teams";
	$queryresultMatch = mysql_query($sqlMatch)
	or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$teamID = $rowMatch['teamID'];
		$teamNameAr = $rowMatch['teamNameAr'];
		echo "	<option value=\"$teamID\">$teamNameAr</option>";
	}
	mysql_free_result($queryresultMatch);
	echo "	</select></td></tr>\n";
	echo "	<tr>\n";
	echo "	<td colspan=\"2\"><input type=\"submit\" value=\"Add content\"></td>\n";
	echo "	</tr>\n";
}

elseif (isset($_GET["type"])) {
	$SesTypIDGet = $_GET["type"];
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·‰«œÌ «·„‰ ﬁ· „‰Â</td>\n";
	echo "	<td>\n <select name = \"teamFrom\" id =\"teamFrom\" onChange=\"location.href='addTransfers.php?type=$SesTypIDGet&team='+this.options[this.selectedIndex].value;\">";
	echo "	<option value=\"\"> </option>";
	$sqlMatch = "SELECT * FROM teams";
	$queryresultMatch = mysql_query($sqlMatch)
			or die(mysql_error());
	while ($rowMatch = mysql_fetch_assoc($queryresultMatch)) {
		$teamID = $rowMatch['teamID'];
		$teamNameAr = $rowMatch['teamNameAr'];
		echo "	<option value=\"$teamID\">$teamNameAr</option>";
	}
	mysql_free_result($queryresultMatch);
	echo "	</select></td></tr>\n";

}

else {
	echo $beginForm;
	echo $beginTable;
	echo "	<tr>\n";
	echo "	<td>«·‰Ê⁄</td>\n";
	echo "	<td>\n";
	echo "<select name = \"match\" id =\"match\" onChange=\"location.href='addTransfers.php?type='+this.options[this.selectedIndex].value;\">";
	echo makeSesType();
	echo "	</td></tr>\n";

}

echo "</table>\n";
echo "</form>\n";

if (isset($_POST['players']) && isset($_POST["season"]) && isset($_GET["team"])  && isset($_GET["type"])) {
	include 'db_conn.php';
	$player = $_POST['players'];
	$season = $_POST['season'];
	$teamTo = $_POST['teamTo'];
	$teamFrom = $_GET['team'];
	$type = $_GET["type"];

	$sqlInSes = "SELECT * FROM inseason WHERE inseasonSeason='$season' AND inseasonTeam='$teamFrom' AND inseasonType='$type'";
	$queryresultInSes = mysql_query($sqlInSes)
		or die(mysql_error());
	while($rowInSes = mysql_fetch_assoc($queryresultInSes)){
		$PlayerInSes = $rowInSes['inseasonMember'];
		array_push($arrayInSesM, "$PlayerInSes");
	}
	$numRows = mysql_num_rows($queryresultInSes);

	if ($numRows == 0) {
		$sql = "UPDATE players SET playerTeam='$teamTo'
		WHERE playerID='$player' AND playerTeam='$teamFrom'";
		mysql_query($sql) or die (mysql_error());
	} else {
		// update the member if he was in another team to let him be transfered
		$sqlInSeason = "UPDATE inseason SET inseasonTransfer='1'
		WHERE inseasonSeason='$season' AND inseasonTeam='$teamFrom' AND inseasonMember='$player' AND inseasonType='$type'";
			mysql_query($sqlInSeason) or die (mysql_error());
		// insert him in the season for his new team
		$sql = "INSERT INTO inseason (`inseasonSeason`, `inseasonTeam`, `inseasonMember`, `inseasonType`)
							VALUES ('$season', '$teamTo', '$player', '$type');";
		mysql_query($sql) or die (mysql_error());
		// update his recored in the default team
		$sql = "UPDATE players SET playerTeam='$teamTo'
		WHERE playerID='$player' AND playerTeam='$teamFrom'";
			mysql_query($sql) or die (mysql_error());
	}

	echo " „ «÷«›… «·„œŒ·«  »‰Ã«Õ!";
	echo "<a href=\"addInSeason.php\">«·⁄Êœ…</a>";
	echo redirection();
	mysql_close($conn);
}
echo "</div>";
// making footer
echo makeFooter();

?>